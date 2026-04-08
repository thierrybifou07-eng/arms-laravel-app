<?php

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\AuditType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuditLog>
 */
class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = ['CREATE', 'UPDATE', 'DELETE', 'READ', 'LOGIN', 'LOGOUT', 'DOWNLOAD', 'EXPORT', 'IMPORT'];
        $modelTypes = [
            'App\Models\User',
            'App\Models\Contract',
            'App\Models\Payment',
            'App\Models\Residence',
            'App\Models\Building',
            'App\Models\Room',
        ];

        $action = $this->faker->randomElement($actions);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'audit_type_id' => AuditType::where('code', strtolower($action))->first()?->id ?? 1,
            'auditable_type' => $this->faker->randomElement($modelTypes),
            'auditable_id' => $this->faker->randomNumber(3),
            'model_type' => $this->faker->randomElement($modelTypes),
            'model_id' => $this->faker->randomNumber(3),
            'action' => $action,
            'details' => $this->faker->sentence(),
            'old_values' => $action === 'UPDATE' ? [
                'status' => 'pending',
                'amount' => $this->faker->numberBetween(100, 1000),
            ] : null,
            'new_values' => in_array($action, ['CREATE', 'UPDATE']) ? [
                'status' => $this->faker->randomElement(['active', 'completed', 'pending']),
                'amount' => $this->faker->numberBetween(100, 5000),
            ] : null,
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE', 'PATCH']),
            'url' => $this->faker->url(),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the audit log is for a creation.
     */
    public function forCreation(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'CREATE',
                'old_values' => null,
                'new_values' => [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                    'status' => 'active',
                ],
            ];
        });
    }

    /**
     * Indicate that the audit log is for an update.
     */
    public function forUpdate(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'UPDATE',
                'old_values' => [
                    'status' => 'pending',
                    'amount' => $this->faker->numberBetween(100, 1000),
                ],
                'new_values' => [
                    'status' => 'completed',
                    'amount' => $this->faker->numberBetween(1000, 5000),
                ],
            ];
        });
    }

    /**
     * Indicate that the audit log is for a deletion.
     */
    public function forDeletion(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'DELETE',
                'old_values' => [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                    'status' => 'active',
                ],
                'new_values' => null,
            ];
        });
    }

    /**
     * Indicate that the audit log is for a login.
     */
    public function forLogin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'LOGIN',
                'model_type' => 'App\Models\User',
                'model_id' => $attributes['user_id'],
                'details' => 'User logged in',
                'old_values' => null,
                'new_values' => null,
            ];
        });
    }

    /**
     * Indicate that the audit log is for a logout.
     */
    public function forLogout(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'LOGOUT',
                'model_type' => 'App\Models\User',
                'model_id' => $attributes['user_id'],
                'details' => 'User logged out',
                'old_values' => null,
                'new_values' => null,
            ];
        });
    }

    /**
     * Indicate that the audit log is for an export.
     */
    public function forExport(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'action' => 'EXPORT',
                'details' => 'Exported ' . $this->faker->randomElement(['Payments', 'Contracts', 'Users', 'Residences']) . ' data',
                'old_values' => null,
                'new_values' => null,
            ];
        });
    }

    /**
     * Indicate that the audit log is for the last 7 days.
     */
    public function thisWeek(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
            ];
        });
    }

    /**
     * Indicate that the audit log is for today.
     */
    public function today(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-24 hours', 'now'),
            ];
        });
    }

    /**
     * Indicate that the audit log is for a specific user.
     */
    public function forUser($userId): static
    {
        return $this->state(function (array $attributes) use ($userId) {
            return [
                'user_id' => $userId,
            ];
        });
    }
}
