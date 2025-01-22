<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    protected $model = Apartment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName,
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'rating' => $this->faker->numberBetween(1, 5),
            'capacity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'discounted_price' => $this->faker->randomFloat(2, 80, 900),
            'available' => $this->faker->boolean,
            'user_id' => User::whereHas('role', function ($query) {
                $query->where('name', 'apartment_owner');
            })->inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
