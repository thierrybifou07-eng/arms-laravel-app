<?php

namespace Database\Seeders;

use App\Models\Residence;
use App\Models\ResidenceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Residence::factory()->count(18)->create();
    }
}
