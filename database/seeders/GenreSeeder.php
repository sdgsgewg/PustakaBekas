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
            'name' => 'Thriller',
            'slug' => 'thriller',
            'category_id' => 1
        ]);
        Genre::create([
            'name' => 'Romance',
            'slug' => 'romance',
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
    }
}
