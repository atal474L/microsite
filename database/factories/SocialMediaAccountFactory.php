<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SocialMediaAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
//            'profile_id' => $this->faker->unique()->randomNumber(),
//            'access_token' => Str::random(50),
        ];
    }
}
