<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
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
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'count' => $this->faker->numberBetween(1, 10),
            'rating' => $this->faker->numberBetween(1, 5),
            'capacity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'discounted_price' => $this->faker->randomFloat(2, 30, 400),
            'available' => $this->faker->boolean,
            'hotel_id' => Hotel::inRandomOrder()->first()->id ?? Hotel::factory(),
        ];
    }
}
