<?php

use App\Models\Role;
use App\Models\UserStatus;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('auth-register-wide');
});

test('new users can register', function () {
    UserStatus::firstOrCreate(
        ['code' => UserStatus::PENDING],
        ['label' => 'Pending']
    );

    Role::firstOrCreate(
        ['name' => Role::STUDENT],
        ['label' => 'Student']
    );

    $response = $this->post('/register', [
        'firstname' => 'Test',
        'lastname' => 'User',
        'email' => 'test@example.com',
        'phone' => '(237) 600 00 00 00',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('registration validation reuses only the national phone number in old input', function () {
    $response = $this->from('/register')->post('/register', [
        'firstname' => 'Test',
        'lastname' => 'User',
        'email' => 'not-an-email',
        'phone' => '(+237) 699 00 00 00',
        'phone_display' => '699 00 00 00',
        'phone_country' => 'cm',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('email');

    expect(session()->getOldInput('phone'))->toBe('699 00 00 00');
    expect(session()->getOldInput('phone_country'))->toBe('cm');
});
