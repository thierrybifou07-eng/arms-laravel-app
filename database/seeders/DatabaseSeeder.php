<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Order is important to respect foreign key constraints.
     */
    public function run(): void
    {
        $this->call([
            UserStatusSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            ResidenceStatusSeeder::class,
            BuildingStatusSeeder::class,
            FloorStatusSeeder::class,
            RoomStatusSeeder::class,
            ContractStatusSeeder::class,
            PaymentStatusSeeder::class,
            BillingPeriodSeeder::class,
            PaymentMethodSeeder::class,
            EventPaymentTypeSeeder::class,
            UserSeeder::class,
        ]);
        $this->call([
            ResidenceInfrastructureSeeder::class,       // Create residences, buildings, floors, rooms
            AdminResidenceSeeder::class,                 // Assign admins to all residences
        ]);
    }
}
