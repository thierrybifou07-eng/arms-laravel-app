<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractStatusSeeder extends Seeder
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
            ['code' => 'terminated',
                'label' => 'Terminated',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'cancelled',
                'label' => 'Cancelled',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\ContractStatus::create($status);
        }
    }
}
