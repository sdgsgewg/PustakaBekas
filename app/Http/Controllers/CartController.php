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
        $cart = Cart::with('books')->where('user_id', Auth::id())->first();
        
        $carts = Cart::with('books')->where('user_id', Auth::id())->get();
        
        $cartItems = [];
        foreach ($carts as $cart) {
            foreach ($cart->books as $book) {
                $sellerId = $book->seller->id;
                $sellerName = $book->seller->name;
                $sellerUsername = $book->seller->username;
    
                if (!isset($cartItems[$sellerId])) {
                    $cartItems[$sellerId] = [
                        'seller_name' => $sellerName,
                        'seller_username' => $sellerUsername,
                        'items' => []
                    ];
                }
    
                $cartItems[$sellerId]['items'][] = $book;
            }
        }

        return view('cart.cart', [
            'title' => 'My Cart',
            'cart' => $cart,
            'cartItems' => $cartItems
        ]);
    }

    public function checkout()
    {
        $cart = Cart::with('books')->where('user_id', Auth::id())->first();
        
        $carts = Cart::with('books')->where('user_id', Auth::id())->get();
        $checkoutItems = [];
        foreach ($carts as $cart) {
            foreach ($cart->books as $book) {
                if ($book->pivot->isChecked) {
                    $sellerId = $book->seller->id;
                    $sellerName = $book->seller->name;
                    $sellerUsername = $book->seller->username;
        
                    if (!isset($checkoutItems[$sellerId])) {
                        $checkoutItems[$sellerId] = [
                            'seller_name' => $sellerName,
                            'seller_username' => $sellerUsername,
                            'items' => []
                        ];
                    }
        
                    $checkoutItems[$sellerId]['items'][] = $book;
                }
            }
        }

        $productAmount = [];
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $amount = 0;
            foreach($sellerGroup['items'] as $item) {
                $amount += $item->pivot->quantity;
            }
            $productAmount[] = $amount;
        }

        $checkoutItemsPrice = [];
        $totalPrice = 0;
        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            $subtotalPrice = 0;
            foreach($sellerGroup['items'] as $item) {
                $subtotalPrice += ($item->price * $item->pivot->quantity);
            }
            $checkoutItemsPrice[] = $subtotalPrice;
            $totalPrice += $subtotalPrice;
        }

        return view('cart.checkout', [
            'title' => 'Checkout',
            'cart' => $cart,
            'checkoutItems' => $checkoutItems,
            'productAmount' => $productAmount,
            'checkoutItemsPrice' => $checkoutItemsPrice,
            'totalPrice' => $totalPrice
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
    public function store(Request $request)
    {
        $book = Book::find($request->book_id);
        
        if (!$book) {
            return redirect()->back()->with('error', 'Book not found.');
        }

        $user = Auth::user();
        
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartBook = $cart->books()->where('book_id', $book->id)->first();

        if ($cartBook) {
            $cart->books()->updateExistingPivot($book->id, [
                'quantity' => $cartBook->pivot->quantity + 1,
                'isChecked' => true
            ]);
        } else {
            $cart->books()->attach($book->id, [
                'quantity' => 1,
                'isChecked' => true
            ]);
        }
        
        return redirect()->route('carts.index')->with('success', 'Book added to cart!');
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

        $cart = Cart::find($cart->id);
    
        if ($cart) {
            $cart->books()->updateExistingPivot($bookId, ['quantity' => $validatedData['quantity']]);
            return redirect()->back();
        }
    }

    public function updateIsChecked(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:cart_books,book_id',
            'is_checked' => 'required|boolean',
        ]);

        // Find the cart item by book ID and update its isChecked status
        $cartItem = Cart::where('user_id', Auth::id())
            ->whereHas('books', function ($query) use ($request) {
                $query->where('book_id', $request->book_id);
            })
            ->first();

        if ($cartItem) {
            $cartItem->books()->updateExistingPivot($request->book_id, ['isChecked' => $request->is_checked]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:cart_books,book_id',
            'quantity' => 'required|integer|min:0'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->whereHas('books', function ($query) use ($request) {
                $query->where('book_id', $request->book_id);
            })
            ->first();

        if ($cartItem) {
            $cartItem->books()->updateExistingPivot($request->book_id, ['quantity' => $request->quantity]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cart $cart)
    {
        $bookId = $request->input('book_id');
        $cart->books()->detach($bookId);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
