<?php

namespace Database\Seeders;

use App\Models\BillingPeriod;
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

        // Billing Periods
/*         BillingPeriod::firstOrCreate(
            ['code' => 'monthly'],
            ['label' => 'Monthly', 'days' => 30]
        );
        BillingPeriod::firstOrCreate(
            ['code' => 'quarterly'],
            ['label' => 'Quarterly', 'days' => 90]
        );
        BillingPeriod::firstOrCreate(
            ['code' => 'half_yearly'],
            ['label' => 'Half-Yearly', 'days' => 180]
        );
        BillingPeriod::firstOrCreate(
            ['code' => 'yearly'],
            ['label' => 'Yearly', 'days' => 365]
        ); */
    }
}
