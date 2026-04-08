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
        // 1. Seed enum and reference tables first
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
            AuditTypeSeeder::class,
        ]);

        // 2. Seed core data
        $this->call([
            UserSeeder::class,                          // Create 500 users with roles
            SuperAdminPermissionSeeder::class,
        ]);

        // 3. Seed infrastructure
        $this->call([
            ResidenceInfrastructureSeeder::class,       // Create residences, buildings, floors, rooms
            AdminResidenceAssignmentSeeder::class,      // Assign admins to residences
        ]);

        // 4. Seed business logic data
        $this->call([
            ContractSeeder::class,                      // Create contracts for students
            PaymentSeeder::class,                       // Create payments and payment histories
            PaymentReceiptSeeder::class,                // Create receipts for validated payments
        ]);

        // 5. Seed audit logs (demo data)
        $this->call([
            AuditLogSeeder::class,                      // Create test audit logs for dashboard
        ]);

        $this->command->info("\n✓ Database seeding completed successfully!");
        $this->command->info("Database contains:");
        $this->command->info("  - 500 users (1 super_admin, 5 admins, 15 staff, 20 tellers, 459 students)");
        $this->command->info("  - 10 residences");
        $this->command->info("  - ~30-50 buildings (max 5 per residence)");
        $this->command->info("  - ~300-750 floors (max 15 per building)");
        $this->command->info("  - ~6000-18750 rooms (max 25 per floor)");
        $this->command->info("  - 1000+ contracts with all statuses (pending, active, overdue, expired, archived, cancelled)");
        $this->command->info("  - 5000+ payments with all statuses (pending, processing, validated, cancelled)");
        $this->command->info("  - 10000+ payment histories\n");
    }
}
