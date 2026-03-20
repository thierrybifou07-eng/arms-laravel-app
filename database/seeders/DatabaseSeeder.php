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
            UserSeeder::class,
            ResidenceStatusSeeder::class,
            BuildingStatusSeeder::class,
            FloorStatusSeeder::class,
            RoomStatusSeeder::class,
            ContractStatusSeeder::class,
            PaymentStatusSeeder::class,
            BillingPeriodSeeder::class,
            PaymentMethodSeeder::class,
            EventPaymentTypeSeeder::class,
        ]);
        // Select status active by default
        $activeId = UserStatus::getIdByCode(UserStatus::ACTIVE);

        User::factory()->create([
            'firstname' => 'Test User',
            'lastname' => 'Test Lastname',
            'email' => 'test@example.com',
            'user_status_id' => $activeId,
        ]);

    }
}
