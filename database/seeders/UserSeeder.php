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
        // Create Super Admin
        $superAdmin = User::create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'super@admin.com',
            'phone' => '+237670000000',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'active')->first()->id,
        ]);
        $superAdmin->roles()->attach(Role::where('code', 'super_admin')->first()->id);

        // Create Admin users (5)
        for ($i = 1; $i <= 5; $i++) {
            $admin = User::create([
                'firstname' => "Admin",
                'lastname' => "User {$i}",
                'email' => "admin{$i}@arms.test",
                'phone' => "+2376700000{$i}",
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            $admin->roles()->attach(Role::where('code', 'admin')->first()->id);
        }

        // Create Staff users (15)
        for ($i = 1; $i <= 15; $i++) {
            $staff = User::create([
                'firstname' => "Staff",
                'lastname' => "User {$i}",
                'email' => "staff{$i}@arms.test",
                'phone' => "+237670001{$i:02d}",
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            $staff->roles()->attach(Role::where('code', 'staff')->first()->id);
        }

        // Create Teller users (20)
        for ($i = 1; $i <= 20; $i++) {
            $teller = User::create([
                'firstname' => "Teller",
                'lastname' => "User {$i}",
                'email' => "teller{$i}@arms.test",
                'phone' => "+237670002{$i:02d}",
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            $teller->roles()->attach(Role::where('code', 'teller')->first()->id);
        }

        // Create Student users (459)
        for ($i = 1; $i <= 459; $i++) {
            $randomStatus = fake()->boolean(80) 
                ? UserStatus::where('code', 'active')->first()->id
                : UserStatus::where('code', 'pending')->first()->id;
            
            $student = User::create([
                'firstname' => "Student",
                'lastname' => "User {$i}",
                'email' => "student{$i}@arms.test",
                'phone' => "+237670003" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'user_status_id' => $randomStatus,
            ]);
            $student->roles()->attach(Role::where('code', 'student')->first()->id);
        }

        $this->command->info('✓ 500 users created successfully (1 super_admin, 5 admins, 15 staff, 20 tellers, 459 students)');
    }
}
