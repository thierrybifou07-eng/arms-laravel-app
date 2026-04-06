<?php

namespace Database\Factories;

use App\Models\Residence;
use App\Models\ResidenceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Residence>
 */
class ResidenceFactory extends Factory
{
    protected $model = Residence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->lastName(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'capacity' => fake()->numberBetween(1, 10),
            'residence_status_id' => fake()->randomElement([ResidenceStatus::getIdByCode(ResidenceStatus::ACTIVE), ResidenceStatus::getIdByCode(ResidenceStatus::CLOSED), ResidenceStatus::getIdByCode(ResidenceStatus::RENEW)]), // Default status
        ];
    }
}
