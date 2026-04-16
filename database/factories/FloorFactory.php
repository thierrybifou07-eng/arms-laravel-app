<?php

namespace Database\Factories;

use App\Models\Floor;
use App\Models\Building;
use App\Models\FloorStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Floor>
 */
class FloorFactory extends Factory
{
    protected $model = Floor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'building_id' => Building::factory(),
            'floor_status_id' => FloorStatus::where('code', FloorStatus::ACTIVE)->first()->id ?? 1,
            'number' => fake()->numberBetween(1, 15),
            'capacity' => fake()->numberBetween(25, 35),
        ];
    }
}
