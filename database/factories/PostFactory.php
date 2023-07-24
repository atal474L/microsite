<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['PHOTO', 'VIDEO', 'CAROUSEL_ALBUM']),
            'caption' => $this->faker->text(50),
            'likes' => $this->faker->numberBetween(0,50),
            'external_id' => $this->faker->unique()->numberBetween(0,155555555),
            'posted_at' => $this->faker->dateTimeBetween('now', '+7 days'),
        ];
    }
}
