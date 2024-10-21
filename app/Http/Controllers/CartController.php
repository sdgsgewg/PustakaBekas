<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    public function store(Request $request, Book $book)
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
    public function update(Request $request, Cart $cart)
    {
        $bookId = $request->input('book_id');
        $book = Book::find($bookId);

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0|max:' . $book["stock"]
        ]);

        if($validatedData['quantity'] == 0) {
            return $this->destroy($cart, $bookId);
        }

        $cart = Cart::find($cart->id);
    
        if ($cart) {
            $cart->books()->updateExistingPivot($bookId, ['quantity' => $validatedData['quantity']]);
    
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $bookId)
    {
        $cart->books()->detach($bookId);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
