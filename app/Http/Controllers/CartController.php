<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('books')->where('user_id', Auth::id())->get();

        return view('cart', [
            'title' => 'My Cart',
            'carts' => $carts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request, Book $book)
    {
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }

        $user = Auth::user();
        
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        
        $cartBook = $cart->books()->where('book_id', $book->id)->first();

        if ($cartBook) {
            $cart->books()->updateExistingPivot($book->id, [
                'quantity' => $cartBook->pivot->quantity + 1
            ]);
        } else {
            $cart->books()->attach($book->id, ['quantity' => 1]);
        }

        // Redirect to the cart page with success message
        return redirect('/carts')->with('success', 'Book added to cart!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
