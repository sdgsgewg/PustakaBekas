<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $trendingBooks = Book::orderBy('rating', 'desc')->take(6)->get();
        $latestBooks = Book::latest()->take(3)->get();

        return view('home', [
            'title' => 'Home Page', 
            'trendingBooks' => $trendingBooks,
            'latestBooks' => $latestBooks
        ]);
    }
}
