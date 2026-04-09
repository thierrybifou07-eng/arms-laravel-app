<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Contract;
use App\Models\PaymentStatus;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $expectedAmount = fake()->randomFloat(2, 50000, 250000);
        $paymentDate = fake()->dateTimeBetween('-1 year', 'now');
        
        return [
            'contract_id' => Contract::factory(),
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()?->id ?? null,
            'payment_status_id' => PaymentStatus::where('code', PaymentStatus::PENDING)->first()->id ?? 1,
            'expected_amount' => $expectedAmount,
            'paid_amount' => 0,
            'payment_date' => null,
            'due_date' => fake()->dateTimeBetween('now', '+3 months'),
        ];
    }

    /**
     * Payment with pending status
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status_id' => PaymentStatus::where('code', PaymentStatus::PENDING)->first()->id ?? 1,
                'paid_amount' => 0,
                'payment_date' => null,
            ];
        });
    }

    /**
     * Payment with processing status
     */
    public function processing()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status_id' => PaymentStatus::where('code', PaymentStatus::PROCESSING)->first()->id ?? 1,
                'paid_amount' => $attributes['expected_amount'] * 0.5, // Half paid while processing
                'payment_date' => now()->subDays(fake()->numberBetween(1, 10)),
            ];
        });
    }

    /**
     * Payment with validated status
     */
    public function validated()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status_id' => PaymentStatus::where('code', PaymentStatus::VALIDATED)->first()->id ?? 1,
                'paid_amount' => $attributes['expected_amount'],
                'payment_date' => now()->subDays(fake()->numberBetween(1, 30)),
            ];
        });
    }

    /**
     * Payment with pending status (for overdue)
     */
    public function pending_old()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status_id' => PaymentStatus::where('code', PaymentStatus::PENDING)->first()->id ?? 1,
                'paid_amount' => 0,
                'payment_date' => null,
            ];
        });
    }

    /**
     * Payment with cancelled status
     */
    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status_id' => PaymentStatus::where('code', PaymentStatus::CANCELLED)->first()->id ?? 1,
                'paid_amount' => 0,
                'payment_date' => null,
            ];
        });
    }
}
