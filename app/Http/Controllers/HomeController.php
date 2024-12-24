<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRating;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $trendingBooks = Book::with('reviews')
        ->select('books.*')
        ->selectRaw('AVG(book_reviews.rating) as avg_rating')
        ->join('book_reviews', 'books.id', '=', 'book_reviews.book_id')
        ->groupBy('books.id')
        ->orderByDesc('avg_rating')
        ->take(8)
        ->get();

        $latestBooks = Book::latest()->take(4)->get();

        return view('home', [
            'title' => 'Home Page', 
            'trendingBooks' => $trendingBooks,
            'latestBooks' => $latestBooks
        ]);
    }
}
