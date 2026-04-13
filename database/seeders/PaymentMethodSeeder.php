<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run()
    {
        $methods = [
            ['code' => 'cash', 'label' => 'Cash'],
            ['code' => 'mtn_money', 'label' => 'MTN Mobile Money'],
            ['code' => 'orange_money', 'label' => 'Orange Money'],
            ['code' => 'cryptos', 'label' => 'Cryptocurrencies'],
            ['code' => 'bank_transfer', 'label' => 'Bank Transfer'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
