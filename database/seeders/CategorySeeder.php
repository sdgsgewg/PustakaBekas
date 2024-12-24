<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Fiction',
            'slug' => 'fiction'
        ]);
        Category::create([
            'name' => 'Non-Fiction',
            'slug' => 'non-fiction'
        ]);
        Category::create([
            'name' => 'Education',
            'slug' => 'education'
        ]);
        Category::create([
            'name' => 'Religion',
            'slug' => 'religion'
        ]);
        Category::create([
            'name' => 'Comic',
            'slug' => 'comic'
        ]);
    }
}
