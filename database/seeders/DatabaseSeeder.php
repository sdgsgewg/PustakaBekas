<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Genre;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Jessen',
            'username' => 'jessen',
            'email' => 'jessen123ptk@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'address' => 'Orange Street',
            'phoneNumber' => '08123456789',
            'is_admin' => 1,
            'remember_token' => Str::random(10)
        ]);

        // User::create([
        //     'name' => 'Asep',
        //     'email' => 'asep123ptk@gmail.com',
        //     'password' => bcrypt('asep123')
        // ]);

        User::factory(3)->create();

        Genre::create([
            'name' => 'Thriller',
            'slug' => 'thriller'
        ]);
        Genre::create([
            'name' => 'Romance',
            'slug' => 'romance'
        ]);
        Genre::create([
            'name' => 'Comedy',
            'slug' => 'comedy'
        ]);

        Book::factory(15)->create();
        
    }
}
