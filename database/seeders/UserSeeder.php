<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserStatus;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activateId = \App\Models\UserStatus::where('code', 'active')->first()->id;
        $users = 
            ['name' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '+237 697 147 114',
                'password' => '12345678',
                'user_status_id' => $activateId,
                ];
        User::create(
            [
                'name'=>$users['name'],
                'email'=>$users['email'],
                'phone'=>$users['phone'],
                'password'=>$users['password'],
                'user_status_id'=>$users['user_status_id'],
            ]
        );
    }
}
