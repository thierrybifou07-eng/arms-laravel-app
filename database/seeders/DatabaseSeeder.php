<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserStatus;
use App\Models\ResidenceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User as AuthUser;

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
            UserSeeder::class,
            ResidenceStatusSeeder::class
        ]);
        // Select status active by default
        $activeId = UserStatus::getIdByCode(UserStatus::ACTIVE);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_status_id' => $activeId,
        ]);

    }
}
