<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'All Books';

        // Handle search query
        if (request('search')) {
            $title .= ' for "' . request('search') . '"';
            return view('books.books', [
                'title' => $title,
                'books' => Book::latest()->filter(request(['search', 'genre', 'seller']))->paginate(7)->withQueryString()
            ]);
        }

        if (request('genre')) {
            $genre = Genre::firstWhere('slug', request('genre'));
            $title .= ' in ' . $genre->name;
            return view('books.books', [
                'title' => $title,
                'books' => Book::latest()->filter(request(['search', 'genre', 'seller']))->paginate(7)->withQueryString()
            ]);
        }

        if (request('seller')) {
            $seller = User::firstWhere('username', request('seller'));
            $title .= ' by ' . $seller->name;
            return view('books.books', [
                'title' => $title,
                'books' => Book::latest()->filter(request(['search', 'genre', 'seller']))->paginate(7)->withQueryString()
            ]);
        }

        return view('books.books', [
            'title' => $title,
            'books' => Book::latest()->paginate(7),
            'user' => Auth::user()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.book', [
            'title' => 'Single Book',
            'book' => $book
        ]);
    }
}
