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
            'firstname' => 'Pierre Gedéon',
            'lastname' => 'Bifou Ngo\'o',
            'email' => 'bifoungoo@gmail.com',
            'phone' => '+237697147114',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'active')->first()->id,
        ]);
        // Assign the single super_admin role
        $superAdmin->roles()->sync([Role::where('name', 'super_admin')->first()->id]);

        // Create Admin users (1)
        $admin = User::create([
            'firstname' => 'Yannick',
            'lastname' => 'Mbena',
            'email' => 'yannickmbenakombo@gmail.com',
            'phone' => '+237699000000',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'active')->first()->id,
        ]);
        // Assign the admin role
        $admin->roles()->sync([Role::where('name', 'admin')->first()->id]);

        // Create Staff users (3)
        $staff = User::create([
            'firstname' => 'Leonard',
            'lastname' => 'dev',
            'email' => 'leonardev19@gmail.com',
            'phone' => '+237699000001',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'active')->first()->id,
        ]);
        // Assign the staff role
        $staff->roles()->sync([Role::where('name', 'staff')->first()->id]);
        for ($i = 1; $i <= 2; $i++) {
            $staff = User::create([
                'firstname' => 'Staff',
                'lastname' => "User {$i}",
                'email' => "staff{$i}@gmail.com",
                'phone' => '+237670001'.sprintf('%02d', $i),
                'password' => Hash::make('password'),
                'user_status_id' => UserStatus::where('code', 'active')->first()->id,
            ]);
            // Assign the single staff role
            $staff->roles()->sync([Role::where('name', 'staff')->first()->id]);
        }

        // Create Student users (15)
        $student = User::create([
            'firstname' => 'Mathurin',
            'lastname' => 'Manga',
            'email' => 'mathurinngamanga@gmail.com',
            'phone' => '+237699000002',
            'password' => Hash::make('password'),
            'user_status_id' => UserStatus::where('code', 'pending')->first()->id,
        ]);
        // Assign the student role
        $student->roles()->sync([Role::where('name', 'student')->first()->id]);
        for ($i = 1; $i <= 14; $i++) {
            $randomStatus = fake()->boolean(80)
                ? UserStatus::where('code', 'active')->first()->id
                : UserStatus::where('code', 'pending')->first()->id;

            $student = User::create([
                'firstname' => 'Student',
                'lastname' => "Resident {$i}",
                'email' => "student{$i}@gmail.com",
                'phone' => '+237670003'.str_pad($i, 3, '0', STR_PAD_LEFT),
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
