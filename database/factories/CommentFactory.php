<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author'   => '익명',
            'content'  => $this->faker->sentence(),
            'password' => bcrypt('1234'),
        ];
    }
}