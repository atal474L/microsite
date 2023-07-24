<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->imageUrl(),
            'external_id' => $this->faker->unique()->randomNumber(),
        ];
    }
}
