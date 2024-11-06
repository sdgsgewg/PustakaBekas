<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $title = 'All Books';
        $query = Book::latest();

        // Apply filters
        $filteredQuery = $this->applyFilters($query, $title);

        // Check if any filters are applied
        $isFiltered = request()->has('search') || request()->has('category') || request()->has('genre') || request()->has('seller');

        // Get filtered books without pagination for grouping
        $books = $filteredQuery->get();

        // Group books by category, then by genre within each category
        $booksByCategory = $books->groupBy('category_id')->map(function ($categoryBooks) {
            return $categoryBooks->groupBy(function ($book) {
                // Group by all genres of the book (if multiple genres)
                return $book->genres->pluck('id')->toArray(); // Return an array of genre IDs
            });
        });

        // Determine which view to return based on whether filters are applied
        $viewName = $isFiltered ? 'books.bookFiltered' : 'books.books';

        return view($viewName, [
            'title' => $title,
            'booksByCategory' => $booksByCategory,
            'categories' => Category::all(),
            'genres' => Genre::all(),
            'sellers' => User::has('books')->get(),
            'user' => Auth::user()
        ]);
    }

    protected function applyFilters($query, &$title)
    {
        // Filter by search query
        if (request('search')) {
            $title .= ' for "' . request('search') . '"';
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        // Filter by category
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            if ($category) {
                $title .= ' in ' . $category->name;
                $query->where('category_id', $category->id);
            }
        }

        // Filter by genre (handling multiple genres)
        if (request('genre')) {
            // Ensure genre is an array even if only one genre is selected
            $genres = is_array(request('genre')) ? request('genre') : explode(',', request('genre'));
            
            $genres = Genre::whereIn('slug', $genres)->get();
            if ($genres->isNotEmpty()) {
                $title .= ' in ' . $genres->pluck('name')->implode(', ');
                $query->whereHas('genres', function ($q) use ($genres) {
                    // Specify the table for the 'id' column to avoid ambiguity
                    $q->whereIn('genres.id', $genres->pluck('id'));  // Use genres.id explicitly
                });
            }
        }

        // Filter by seller
        if (request('seller')) {
            $seller = User::firstWhere('username', request('seller'));
            if ($seller) {
                $title .= ' by ' . $seller->name;
                $query->where('user_id', $seller->id);
            }
        }

        return $query;
    }

    public function getGenresByCategory($slug)
    {
        // Ensure that the category exists and fetch its genres
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            // Return genres related to the category
            return response()->json($category->genres);
        }

        return response()->json([]); // Return an empty array if no genres found
    }

    public function show(Book $book)
    {
        return view('books.book', [
            'title' => 'Single Book',
            'book' => $book
        ]);
    }
}
