<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'model' => $this->faker->word,
            'brand' => $this->faker->company,
            'license_plate' => strtoupper($this->faker->bothify('??###')),
            'available' => $this->faker->boolean,
            'rating' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'user_id' => User::whereHas('role', function ($query) {
                $query->where('name', 'car_owner');
            })->inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
