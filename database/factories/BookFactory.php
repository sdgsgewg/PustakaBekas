<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(mt_rand(2,5)),
            'slug' => fake()->slug(),
            'author' => fake()->name(),
            'description' => fake()->paragraph(mt_rand(2,4)),
            'price' => mt_rand(50000, 100000),
            'user_id' => mt_rand(1,4),
            'genre_id' => mt_rand(1,3)
        ];
    }
}
