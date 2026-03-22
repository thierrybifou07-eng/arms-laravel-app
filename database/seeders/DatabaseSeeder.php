<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Student;
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
            StudentSeeder::class,
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
/*         $SuperAdminRoleId = Role::getIdByName(Role::STUDENT);
 */
        User::factory()->count(10)->create([
            'user_status_id' => $activeId,
        ])/* ->roles()->attach($SuperAdminRoleId) */;
        // Select status active by default

        Student::factory()->count(150)->create([
        ]);

    }
}
