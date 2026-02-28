<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([

            UserStatusSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);
        // Select status pending by default
        $pendingId = UserStatus::getIdByCode(UserStatus::PENDING);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_status_id' => $pendingId,
        ]);

    }
}
