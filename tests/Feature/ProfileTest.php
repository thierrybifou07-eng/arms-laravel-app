<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'phone' => '(237) 699 00 00 00',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test', $user->firstname);
    $this->assertSame('User', $user->lastname);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => $user->email,
            'phone' => $user->phone,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('profile page renders avatar urls on the current host', function () {
    config()->set('app.url', 'http://arms-app.railway.app');
    config()->set('filesystems.disks.public.url', 'http://arms-app.railway.app/storage');

    Storage::fake('public');

    $user = User::factory()->create();

    $user->addMedia(UploadedFile::fake()->create('avatar.png', 10, 'image/png'))
        ->toMediaCollection('avatars');

    $relativePath = $user->getFirstMedia('avatars')->getPathRelativeToRoot();

    $response = $this
        ->actingAs($user)
        ->get('http://localhost/profile');

    $response
        ->assertOk()
        ->assertSee('http://localhost/storage/' . $relativePath, false);
});
