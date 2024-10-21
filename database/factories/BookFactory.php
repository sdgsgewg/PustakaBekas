<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(mt_rand(2, 5)),
            'slug' => fake()->slug(),
            'author' => fake()->name(),
            'synopsis' => fake()->paragraph(mt_rand(2, 4)),
            'price' => mt_rand(50000, 100000),
            'stock' => mt_rand(1, 20),
            'user_id' => mt_rand(1, 4),
            'category_id' => mt_rand(1, 2)
        ];
    }

    /**
     * Define the model's genre state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withGenres($count = 1)
    {
        return $this->afterCreating(function (Book $book) use ($count) {
            // Dapatkan kategori dari buku
            $categoryId = $book->category_id;
    
            // Ambil genre yang sesuai dengan kategori
            $genres = Genre::where('category_id', $categoryId)->get();
    
            // Cek apakah ada genre yang tersedia
            if ($genres->count() > 0) {
                // Pilih genre secara acak
                $randomGenres = $genres->random(min($count, $genres->count()))->pluck('id');
                $book->genres()->attach($randomGenres);
            }
        });
    }
}