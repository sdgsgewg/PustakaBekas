<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.books.index', [
            'books' => Book::where('seller_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.books.create', [
            'categories' => Category::all(),
            'genres' => Genre::all()
        ]);
    }

    public function getGenresByCategory($categoryId)
    {
        $genres = Genre::where('category_id', $categoryId)->get();
        return response()->json($genres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:books',
            'category_id' => 'required',
            'author' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|file|max:1024',
            'synopsis' => 'required',
            'genre_id' => 'required|array',
            'genre_id.*' => 'exists:book_genres,id'
        ]);

        // Check if a new image file is uploaded
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('book-images');
        }

        /** @var \App\Models\User $user */
        $validatedData['seller_id'] = Auth::user()->id;

        // Create the book entry
        $book = Book::create($validatedData);
        $book->genres()->attach($request->input('genre_id'));

        return redirect('/dashboard/books')->with('success', 'New book has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('dashboard.books.show', [
            'book' => $book
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $bookGenres = $book->genres->pluck('id')->toArray();

        return view('dashboard.books.edit', [
            'book' => $book,
            'categories' => Category::all(),
            'bookGenres' => $bookGenres
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'author' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|file|max:1024',
            'synopsis' => 'required',
            'genre_id' => 'required|array',
            'genre_id.*' => 'exists:book_genres,id'
        ];

        if($request->slug != $book->slug) {
            $rules['slug'] = 'required|unique:books';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('book-images');
        }

        $validatedData['seller_id'] = Auth::user()->id;

        $book->update($validatedData);
        $book->genres()->sync($validatedData['genre_id']);

        return redirect('/dashboard/books')->with('success', 'Book has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if($book->image) {
            Storage::delete($book->image);
        }
        Book::destroy($book->id);

        return redirect('/dashboard/books')->with('success', 'Book has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Book::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
