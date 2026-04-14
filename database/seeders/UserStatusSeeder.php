<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['code' => 'pending',
                'label' => 'Pending',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'active',
                'label' => 'Active',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'disabled',
                'label' => 'Disabled',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\UserStatus::create($status);
        }
    }
}
