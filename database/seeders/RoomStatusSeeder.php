<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['code' => 'avalaible',
                'label' => 'Avalaible',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'busy',
                'label' => 'Busy',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'renovation',
                'label' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now()],
            ['code' => 'closed',
                'label' => 'Closed',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($statuses as $status) {
            \App\Models\RoomStatus::create($status);
        }
    }
}
