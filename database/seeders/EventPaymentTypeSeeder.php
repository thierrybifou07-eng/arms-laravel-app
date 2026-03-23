<?php

namespace Database\Seeders;

use App\Models\EventPaymentType;
use Illuminate\Database\Seeder;

class EventPaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $events = [
            ['code' => 'created', 'label' => 'Payment created'],
            ['code' => 'validated', 'label' => 'Payment validated'],
            ['code' => 'cancelled', 'label' => 'Payment cancelled'],
        ];

        foreach ($events as $event) {
            EventPaymentType::updateOrCreate(
                ['code' => $event['code']],
                $event
            );
        }
    }
}
