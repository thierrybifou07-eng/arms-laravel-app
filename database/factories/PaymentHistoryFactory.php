<?php

namespace Database\Factories;

use App\Models\PaymentHistory;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentHistory>
 */
class PaymentHistoryFactory extends Factory
{
    protected $model = PaymentHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 10000, 100000);
        $oldBalance = fake()->randomFloat(2, 0, 500000);
        
        return [
            'payment_id' => Payment::factory(),
            'amount' => $amount,
            'old_balance' => $oldBalance,
            'new_balance' => $oldBalance - $amount,
            'recorded_by' => fake()->numberBetween(1, 41), // Random user ID in the teams
            'notes' => fake()->sentence(),
        ];
    }
}
