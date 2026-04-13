<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ResidenceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['code' => 'active',
                'label' => 'Open',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'closed',
                'label' => 'Closed',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\ResidenceStatus::create($status);
        }
    }
}
