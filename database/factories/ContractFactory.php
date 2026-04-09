<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\User;
use App\Models\Room;
use App\Models\ContractStatus;
use App\Models\BillingPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-2 years', '-1 months');
        $endDate = clone $startDate;
        $endDate->modify('+' . fake()->numberBetween(6, 24) . ' months');

        return [
            'user_id' => User::factory(),
            'contract_status_id' => ContractStatus::where('code', ContractStatus::ACTIVE)->first()->id ?? 1,
            'billing_period_id' => BillingPeriod::inRandomOrder()->first()?->id ?? 1,
            'room_id' => Room::factory(),
            'rent_amount' => fake()->randomFloat(2, 50000, 250000),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    /**
     * Contract with pending status
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::PENDING)->first()->id ?? 1,
                'start_date' => now()->addDays(fake()->numberBetween(1, 30)),
                'end_date' => now()->addDays(fake()->numberBetween(90, 730)),
            ];
        });
    }

    /**
     * Contract with active status
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::ACTIVE)->first()->id ?? 1,
            ];
        });
    }

    /**
     * Contract with overdue status
     */
    public function overdue()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::OVERDUE)->first()->id ?? 1,
                'start_date' => now()->subMonths(12),
                'end_date' => now()->addMonths(2),
            ];
        });
    }

    /**
     * Contract with expired status
     */
    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::EXPIRED)->first()->id ?? 1,
                'start_date' => now()->subYear(),
                'end_date' => now()->subMonths(1),
            ];
        });
    }

    /**
     * Contract with archived status
     */
    public function archived()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::ARCHIVED)->first()->id ?? 1,
                'start_date' => now()->subYears(2),
                'end_date' => now()->subYear(),
            ];
        });
    }

    /**
     * Contract with cancelled status
     */
    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'contract_status_id' => ContractStatus::where('code', ContractStatus::CANCELLED)->first()->id ?? 1,
                'start_date' => now()->subMonths(6),
                'end_date' => now()->subMonths(3),
            ];
        });
    }
}
