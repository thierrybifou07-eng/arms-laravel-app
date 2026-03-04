<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentRoleId = Role::getIdByName(Role::SUPER_ADMIN);
        $activateId = \App\Models\UserStatus::where('code', 'active')->first()->id;
        $users =
            ['firstname' => 'admin',
                'lastname' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '+237 697 147 114',
                'password' => '12345678',
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
        )->roles()->attach($studentRoleId);
    }
}
