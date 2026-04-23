<?php

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;

beforeEach(function () {
    UserStatus::create([
        'code' => UserStatus::ACTIVE,
        'label' => 'Active',
    ]);

    UserStatus::create([
        'code' => UserStatus::PENDING,
        'label' => 'Pending',
    ]);

    Role::insert([
        ['name' => Role::SUPER_ADMIN, 'label' => 'System Administrator', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::ADMIN, 'label' => 'Residence Manager', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STAFF, 'label' => 'Staff Member', 'created_at' => now(), 'updated_at' => now()],
        ['name' => Role::STUDENT, 'label' => 'Student', 'created_at' => now(), 'updated_at' => now()],
    ]);
});

function makeSuperAdmin(): User
{
    $user = User::factory()->create([
        'user_status_id' => UserStatus::where('code', UserStatus::ACTIVE)->value('id'),
        'email_verified_at' => now(),
    ]);

    $user->roles()->sync([Role::where('name', Role::SUPER_ADMIN)->value('id')]);

    return $user;
}

it('shows a system-focused dashboard for super admins', function () {
    $superAdmin = makeSuperAdmin();

    $this->actingAs($superAdmin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Manage Users')
        ->assertSee('Audit Logs')
        ->assertDontSee('Recent Payments')
        ->assertDontSee('Recent Contracts');

    $this->actingAs($superAdmin)
        ->get(route('super_admin.dashboard'))
        ->assertRedirect(route('dashboard'));
});

it('keeps super admins out of business-management routes', function () {
    $superAdmin = makeSuperAdmin();

    $this->actingAs($superAdmin)->get(route('payments.index'))->assertForbidden();
    $this->actingAs($superAdmin)->get(route('payment_histories.index'))->assertForbidden();
    $this->actingAs($superAdmin)->get(route('event_payment_types.index'))->assertForbidden();
    $this->actingAs($superAdmin)->get(route('roles.index'))->assertForbidden();
});
