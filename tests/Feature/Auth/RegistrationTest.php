<?php

use App\Models\Role;
use App\Models\UserStatus;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
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
