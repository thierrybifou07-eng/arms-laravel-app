<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $statuses = [
            ['code' => 'pending', 'label' => 'Pending'],
            ['code' => 'paid', 'label' => 'Paid'],
            ['code' => 'validated', 'label' => 'Validated'],
            ['code' => 'cancelled', 'label' => 'Cancelled'],
        ];

        foreach ($statuses as $status) {
            PaymentStatus::updateOrCreate(
                ['code' => $status['code']],
                $status
            );
        }
    }
    
}
