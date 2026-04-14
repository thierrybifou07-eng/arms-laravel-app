<?php

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;

beforeEach(function () {
    UserStatus::create([
        'code' => UserStatus::ACTIVE,
        'label' => 'Active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Role::insert([
        ['name' => Role::SUPER_ADMIN, 'label' => 'System Administrator', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::ADMIN, 'label' => 'Residence Manager', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STAFF, 'label' => 'Staff Member', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STUDENT, 'label' => 'Student', 'created_at' => now(), 'updated_at' => now()],
    ]);
});

function makeUserWithRole(string $roleName, array $attributes = []): User
{
    $user = User::factory()->create(array_merge([
        'user_status_id' => UserStatus::where('code', UserStatus::ACTIVE)->value('id'),
        'email_verified_at' => now(),
    ], $attributes));

    $user->roles()->sync([Role::where('name', $roleName)->value('id')]);

    return $user;
}

it('renders user search results for an admin', function () {
    $admin = makeUserWithRole(Role::ADMIN);
    $target = makeUserWithRole(Role::STUDENT, [
        'firstname' => 'NavSearch',
        'lastname' => 'Target',
        'email' => 'navsearch@example.com',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('search', ['q' => 'NavSearch']));

    $response->assertOk();
    $response->assertSee('Results for');
    $response->assertSee('Users');
    $response->assertSee($target->firstname);
    $response->assertSee(route('users.show', $target), false);
});

it('does not expose user results to staff search', function () {
    $staff = makeUserWithRole(Role::STAFF);
    makeUserWithRole(Role::STUDENT, [
        'firstname' => 'PrivateLookup',
        'lastname' => 'Person',
        'email' => 'private-lookup@example.com',
    ]);

    $response = $this
        ->actingAs($staff)
        ->get(route('search', ['q' => 'PrivateLookup']));

    $response->assertOk();
    $response->assertDontSee('Users');
    $response->assertDontSee('PrivateLookup Person');
});

it('wires the navbar search form to the global search route', function () {
    $student = makeUserWithRole(Role::STUDENT, [
        'firstname' => 'Navbar',
        'lastname' => 'Student',
    ]);

    $response = $this
        ->actingAs($student)
        ->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('action="'.route('search').'"', false);
    $response->assertSee('name="q"', false);
});
