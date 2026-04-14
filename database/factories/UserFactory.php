<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activeStatusId = UserStatus::firstOrCreate(
            ['code' => UserStatus::ACTIVE],
            ['label' => 'Active']
        )->id;

        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'user_status_id' => $activeStatusId,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($user) {
            $studentRoleId = Role::firstOrCreate(
                ['name' => Role::STUDENT],
                ['label' => 'Student']
            )->id;

            if (! $user->roles()->exists()) {
                $user->roles()->sync([$studentRoleId]);
            }
        });
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
