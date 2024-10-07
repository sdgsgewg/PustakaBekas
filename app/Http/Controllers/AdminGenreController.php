<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.genres.index', [
            'genres' => Genre::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:genres|max:255',
            'slug' => 'required|unique:genres',
            'image' => 'image|file|max:1024'
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('genre-images');
        }

        Genre::create($validatedData);

        return redirect('/dashboard/genres')->with('success', 'New genre has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('dashboard.genres.edit', [
            'genre' => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => 'image|file|max:1024'
        ];

        if( $request->slug != $genre->slug )
        {
            $rules['slug'] = 'required|unique:genres';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('genre-images');
        }

        Genre::where('id', $genre->id)->update($validatedData);

        return redirect('/dashboard/genres')->with('success', 'Genre has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        if($genre->image) {
            Storage::delete($genre->image);
        }
        Genre::destroy($genre->id);

        return redirect('/dashboard/genres')->with('success', 'Genre has been deleted!');
    }

    public function checkSlug(request $request)
    {
        $slug = SlugService::createSlug(Genre::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
