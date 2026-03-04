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
                'label' => 'Pending Activation',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'active',
                'label' => 'Active Account',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'suspended',
                'label' => 'Suspended Account',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'disabled',
                'label' => 'Disabled Account',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\UserStatus::create($status);
        }
    }
}
