<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SuperAdminRoleId = Role::getIdByName(Role::SUPER_ADMIN);
        $AdminRoleId = Role::getIdByName(Role::ADMIN);
        $TellerRoleId = Role::getIdByName(Role::TELLER);
        $StaffRoleId = Role::getIdByName(Role::STAFF);
        $StudentRoleId = Role::getIdByName(Role::STUDENT);
        $activateId = UserStatus::where('code', 'active')->first()->id;
        $pendingId = UserStatus::where('code', 'pending')->first()->id;
        $users =
            ['firstname' => 'super',
                'lastname' => 'admin',
                'email' => 'super@admin.com',
                'phone' => '+237 600 000 000',
                'password' => bcrypt('password'),
                'user_status_id' => $activateId,
            ];
        User::create(
            [
                'firstname' => $users['firstname'],
                'lastname' => $users['lastname'],
                'email' => $users['email'],
                'phone' => $users['phone'],
                'password' => $users['password'],
                'user_status_id' => $users['user_status_id'],
            ]
        )->roles()->attach($SuperAdminRoleId);
        $users =
            ['firstname' => 'test',
                'lastname' => 'admin',
                'email' => 'test@admin.com',
                'phone' => '+237 600 000 001',
                'password' => bcrypt('password'),
                'user_status_id' => $pendingId,
            ];
        User::create(
            [
                'firstname' => $users['firstname'],
                'lastname' => $users['lastname'],
                'email' => $users['email'],
                'phone' => $users['phone'],
                'password' => $users['password'],
                'user_status_id' => $users['user_status_id'],
            ]
        )->roles()->attach($AdminRoleId);
        $users =
            ['firstname' => 'test',
                'lastname' => 'teller',
                'email' => 'test@teller.com',
                'phone' => '+237 600 000 002',
                'password' => bcrypt('password'),
                'user_status_id' => $pendingId,
            ];
        User::create(
            [
                'firstname' => $users['firstname'],
                'lastname' => $users['lastname'],
                'email' => $users['email'],
                'phone' => $users['phone'],
                'password' => $users['password'],
                'user_status_id' => $users['user_status_id'],
            ]
        )->roles()->attach($TellerRoleId);
        $users =
            ['firstname' => 'test',
                'lastname' => 'staff',
                'email' => 'test@staff.com',
                'phone' => '+237 600 000 003',
                'password' => bcrypt('password'),
                'user_status_id' => $pendingId,
            ];
        User::create(
            [
                'firstname' => $users['firstname'],
                'lastname' => $users['lastname'],
                'email' => $users['email'],
                'phone' => $users['phone'],
                'password' => $users['password'],
                'user_status_id' => $users['user_status_id'],
            ]
        )->roles()->attach($StaffRoleId);
        $users =
            ['firstname' => 'test',
                'lastname' => 'student',
                'email' => 'test@student.com',
                'phone' => '+237 600 000 004',
                'password' => bcrypt('password'),
                'user_status_id' => $pendingId,
            ];
        User::create(
            [
                'firstname' => $users['firstname'],
                'lastname' => $users['lastname'],
                'email' => $users['email'],
                'phone' => $users['phone'],
                'password' => $users['password'],
                'user_status_id' => $users['user_status_id'],
            ]
        )->roles()->attach($StudentRoleId);

        User::factory()->count(25)->create();
    }
}
