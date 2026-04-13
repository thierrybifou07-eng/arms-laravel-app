<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Floor;
use App\Models\RoomStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'floor_id' => Floor::factory(),
            'room_status_id' => RoomStatus::where('code', RoomStatus::AVAILABLE)->first()->id ?? 1,
            'number' => fake()->numberBetween(1, 25),
            'rent' => fake()->randomFloat(2, 50000, 250000),
            'capacity' => fake()->numberBetween(1, 8),
        ];
    }
}
