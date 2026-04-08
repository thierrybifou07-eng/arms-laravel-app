<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Residence;
use App\Models\BuildingStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'residence_id' => Residence::factory(),
            'building_status_id' => BuildingStatus::where('code', BuildingStatus::ACTIVE)->first()->id ?? 1,
            'name' => 'Building ' . fake()->unique()->numerify('###'),
            'address' => fake()->address(),
            'capacity' => fake()->numberBetween(50, 200),
        ];
    }
}
