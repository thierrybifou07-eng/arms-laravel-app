<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin (only one)
        $superAdmin = User::create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'super@admin.com',
            'phone' => '+237670000000',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'active')->first()->id,
        ]);
        // Assign the single super_admin role
        $superAdmin->roles()->sync([Role::where('name', 'super_admin')->first()->id]);

        // Create Admin users (1)
        for ($i = 1; $i <= 1; $i++) {
            $admin = User::create([
                'firstname' => "Admin",
                'lastname' => "User {$i}",
                'email' => "admin{$i}@arms.test",
                'phone' => "+2376700000{$i}",
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            // Assign the single admin role
            $admin->roles()->sync([Role::where('name', 'admin')->first()->id]);
        }

        // Create Staff users (3)
        for ($i = 1; $i <= 3; $i++) {
            $staff = User::create([
                'firstname' => "Staff",
                'lastname' => "User {$i}",
                'email' => "staff{$i}@arms.test",
                'phone' => "+237670001" . sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            // Assign the single staff role
            $staff->roles()->sync([Role::where('name', 'staff')->first()->id]);
        }

        // Create Student users (15)
        for ($i = 1; $i <= 15; $i++) {
            $randomStatus = fake()->boolean(80) 
                ? UserStatus::where('code', 'active')->first()->id
                : UserStatus::where('code', 'pending')->first()->id;
            
            $student = User::create([
                'firstname' => "Student",
                'lastname' => "Resident {$i}",
                'email' => "student{$i}@arms.test",
                'phone' => "+237670003" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'user_status_id' => $randomStatus,
            ]);
            // Assign the single student role
            $student->roles()->sync([Role::where('name', 'student')->first()->id]);
        }

        $this->command->info('✓ 20 users created successfully with single role assignments');
        $this->command->info('  → 1 super_admin');
        $this->command->info('  → 1 admin');
        $this->command->info('  → 3 staff');
        $this->command->info('  → 15 students');
    }
}
