<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Romance',
            'slug' => 'romance',
            'category_id' => 1
        ]);
        Genre::create([
            'name' => 'Thriller',
            'slug' => 'thriller',
            'category_id' => 1
        ]);
        Genre::create([
            'name' => 'Mystery',
            'slug' => 'mystery',
            'category_id' => 1
        ]);

        Genre::create([
            'name' => 'Biography',
            'slug' => 'biography',
            'category_id' => 2
        ]);
        Genre::create([
            'name' => 'History',
            'slug' => 'history',
            'category_id' => 2
        ]);
        Genre::create([
            'name' => 'Memoar',
            'slug' => 'memoar',
            'category_id' => 2
        ]);

        Genre::create([
            'name' => 'Mathematics',
            'slug' => 'mathematics',
            'category_id' => 3
        ]);
        Genre::create([
            'name' => 'Physics',
            'slug' => 'physics',
            'category_id' => 3
        ]);
        Genre::create([
            'name' => 'Biology',
            'slug' => 'biology',
            'category_id' => 3
        ]);

        Genre::create([
            'name' => 'Theology',
            'slug' => 'theology',
            'category_id' => 4
        ]);
        Genre::create([
            'name' => 'Fiqih',
            'slug' => 'fiqih',
            'category_id' => 4
        ]);
        Genre::create([
            'name' => 'Tasawuf',
            'slug' => 'tasawuf',
            'category_id' => 4
        ]);

        Genre::create([
            'name' => 'Superhero',
            'slug' => 'superhero',
            'category_id' => 5
        ]);
        Genre::create([
            'name' => 'Manga',
            'slug' => 'manga',
            'category_id' => 5
        ]);
        Genre::create([
            'name' => 'Adventure',
            'slug' => 'adventure',
            'category_id' => 5
        ]);
    }
}
