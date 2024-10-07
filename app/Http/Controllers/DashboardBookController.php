<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
            'books' => Book::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.books.create', [
            'genres' => Genre::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:books',
            'genre_id' => 'required',
            'author' => 'required',
            'price' => 'required',
            'image' => 'image|file|max:1024',
            'description' => 'required'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('book-images');
        }

        /** @var \App\Models\User $user */
        $validatedData['user_id'] = Auth::user()->id;

        Book::create($validatedData);

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
        return view('dashboard.books.edit', [
            'book' => $book,
            'genres' => Genre::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $rules = [
            'title' => 'required|max:255',
            'genre_id' => 'required',
            'author' => 'required',
            'price' => 'required',
            'image' => 'image|file|max:1024',
            'description' => 'required'
        ];

        if( $request->slug != $book->slug )
        {
            $rules['slug'] = 'required|unique:books';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('book-images');
        }

        $validatedData['user_id'] = Auth::user()->id;

        Book::where('id', $book->id)->update($validatedData);

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
