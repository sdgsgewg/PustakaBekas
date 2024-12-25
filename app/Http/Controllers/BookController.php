<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    // public function index()
    // {
    //     $title = 'All Books';
    //     $books = Book::latest()->get();
    
    //     // Group books by category, then by genre within each category
    //     $booksByCategory = $books->groupBy('category_id')->map(function ($categoryBooks) {
    //         return $categoryBooks->groupBy(function ($book) {
    //             // Group by all genres of the book (if multiple genres)
    //             return $book->genres->pluck('id')->toArray(); // Return an array of genre IDs
    //         });
    //     });
    
    //     return view('books.books', [
    //         'title' => $title,
    //         'booksByCategory' => $booksByCategory,
    //         'categories' => Category::all(),
    //         'genres' => Genre::all(),
    //         'sellers' => User::has('books')->get(),
    //         'user' => Auth::user()
    //     ]);
    // }

    public function index()
    {
        $title = 'All Books';
        $books = Book::latest()->paginate(8);
    
        return view('books.books', [
            'title' => $title,
            'books' => $books,
            'categories' => Category::all(),
            'genres' => Genre::all(),
            'sellers' => User::has('books')->get(),
            'user' => Auth::user()
        ]);
    }
    
    public function filter(Request $request)
    {
        $title = 'All Books';
        $query = Book::latest();

        $filteredQuery = $this->applyFilters($query, $title);

        // Get the paginated result and append the current query parameters to the pagination links
        $filteredBooks = $filteredQuery->paginate(12)->appends($request->query());

        return view('books.bookFiltered', [
            'title' => $title,
            'filteredBooks' => $filteredBooks,
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
                // $title .= ' in ' . $category->name;
                $query->where('category_id', $category->id);
            }
        }

        // Filter by genre (handling multiple genres)
        if (request('genre')) {
            // Ensure genre is an array even if only one genre is selected
            $genres = is_array(request('genre')) ? request('genre') : explode(',', request('genre'));
            
            $genres = Genre::whereIn('slug', $genres)->get();
            if ($genres->isNotEmpty()) {
                // $title .= ' in ' . $genres->pluck('name')->implode(', ');
                $query->whereHas('genres', function ($q) use ($genres) {
                    // Specify the table for the 'id' column to avoid ambiguity
                    $q->whereIn('genres.id', $genres->pluck('id'));  // Use genres.id explicitly
                });
            }
        }

        // Filter by price range
        if (request('min_price') || request('max_price')) {
            $minPrice = request('min_price');
            $maxPrice = request('max_price');

            if ($minPrice !== null) {
                $query->where('price', '>=', $minPrice);
            }
            if ($maxPrice !== null) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        // Filter by rating
        $rating = request('rating');
        if ($rating) {
            $query->join('book_reviews', 'books.id', '=', 'book_reviews.book_id')
                ->select('books.*', DB::raw('AVG(book_reviews.rating) as avg_rating'))
                ->groupBy('books.id')
                ->having('avg_rating', '>=', $rating);
        }

        // Filter by seller
        if (request('seller')) {
            $seller = User::firstWhere('username', request('seller'));
            if ($seller) {
                // $title .= ' by ' . $seller->name;
                $query->where('seller_id', $seller->id);
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

    public function showBookCategory(Category $category) 
    {
        $category->load(['books' => function ($query) {
            $query->latest();
        }, 'books.genres']);
    
        return view('books.book-category', [
            'title' => $category->name . ' Books',
            'category' => $category,
            'categories' => Category::all(),
            'genres' => Genre::all(),
            'sellers' => User::has('books')->get(),
            'user' => Auth::user()
        ]);
    }    

    public function showBookGenre(Genre $genre) 
    {
        $books = $genre->books()->paginate(12);

        return view('books.book-genre', [
            'title' => $genre->name . ' Books',
            'genre' => $genre,
            'books' => $books,
            'categories' => Category::all(),
            'genres' => Genre::all(),
            'sellers' => User::has('books')->get(),
            'user' => Auth::user()
        ]);
    }

    public function show(Book $book)
    {
        $targetBookPrice = $book->price;
        
        // Use the new scope method to get books in the price range
        $books = Book::booksWithinPriceRange(Auth::user()->id, $targetBookPrice)->get();
        
        $comments = Comment::where('book_id', $book->id)->get();

        return view('books.book', [
            'title' => 'Single Book',
            'book' => $book,
            'books' => $books,
            'targetBookPrice' => $targetBookPrice,
            'comments' => $comments
        ]);
    }

    public function showSeller(User $seller)
    {
        $title = 'Seller Page';
        $books = $seller->books()
        ->select('books.*')
        ->selectRaw('IFNULL(AVG(book_reviews.rating), 0) as avg_rating') // Default to 0 for books with no reviews
        ->leftJoin('book_reviews', 'books.id', '=', 'book_reviews.book_id')
        ->groupBy('books.id')
        ->orderByDesc('avg_rating')
        ->paginate(8);

        $averageRating = $seller->books->map(function ($book) {
            return $book->reviews->avg('rating');
        })->avg();

        $averageRating = number_format($averageRating, 2) ?: 0.00;

        return view('books.seller', [
            'title' => $title,
            'seller' => $seller,
            'books' => $books,
            'averageRating' => $averageRating
        ]);
    }

    public function sendFeedback(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:255',
        ]);

        BookReview::Create(
            [
                'user_id' => Auth::user()->id,
                'book_id' => $validated['book_id'],
                'rating' => $validated['rating'],
                'feedback' => $validated['feedback'],
                'isRated' => true,
            ]
        );

        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }

}
