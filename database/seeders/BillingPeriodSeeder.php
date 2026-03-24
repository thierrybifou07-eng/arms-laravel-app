<?php

namespace Database\Seeders;

use App\Models\BillingPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillingPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
    {
        $periodes = [
            ['code' => 'once', 'label' => 'One-time'],
            ['code' => 'monthly', 'label' => 'Monthly'],
            ['code' => 'quarterly', 'label' => 'Quarterly'],
            ['code' => 'half_yearly', 'label' => 'Half-Yearly'],
            ['code' => 'yearly', 'label' => 'Yearly'],
        ];

        foreach ($periodes as $periode) {
            BillingPeriod::updateOrCreate(
                ['code' => $periode['code']],
                $periode
            );
        }
    }
}
