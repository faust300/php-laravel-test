<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author'   => '익명',
            'title'    => $this->faker->sentence(3),
            'content'  => $this->faker->paragraph(),
            'password' => bcrypt('1234'),
        ];
    }
}