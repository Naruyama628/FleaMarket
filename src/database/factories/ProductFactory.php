<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => $this->faker->lastName . $this->faker->firstName,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1, 10000000),
            'image' => '',
            'brand' => $this->faker->company(),
            'condition' => '新品',
            'is_sold' => false,
        ];
    }
}
