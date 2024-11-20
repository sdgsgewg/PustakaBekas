<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User as UserModel;
use App\Models\Category as CategoryModel;
use Faker\Factory as Faker;

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
        $faker = Faker::create('id_ID');

        $users = UserModel::all();
        $categories = CategoryModel::all();

        return [
            'seller_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
            'title' => $faker->sentence(mt_rand(2, 5)),
            'slug' => $faker->slug(),
            'author' => $faker->name(),
            'synopsis' => collect(range(1, 2))
                        ->map(fn() => "<p>" . $faker->text(700) . "</p>")
                        ->implode(''),
            'price' => mt_rand(50000, 200000),
            'stock' => mt_rand(1, 20),
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