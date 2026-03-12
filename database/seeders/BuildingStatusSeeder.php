<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['code' => 'pending',
                'label' => 'Construction',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'active',
                'label' => 'Active',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'closed',
                'label' => 'Closed',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'renew',
                'label' => 'Renovation',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\BuildingStatus::create($status);
        }
    }
}
