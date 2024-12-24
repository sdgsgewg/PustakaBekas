<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // For raw queries like insert
use Illuminate\Support\Facades\Session; // For flashing session messages

class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trades = Trade::where('user_1_id', Auth::id())
            ->get()
            ->map(function ($trade) {
                $trade->nextStatuses = $trade->getNextStatuses();
                
                // Add tradeable_books to each trade
                $trade->tradeable_books = Book::booksWithinPriceRange(Auth::user()->id, $trade->book2->price)->get();
                
                return $trade;
            });

        $status = Trade::select('trade_status')->distinct()->pluck('trade_status')->toArray();
        $allStatus = Trade::STATUSES;

        return view('trade.index', [
            'title' => 'My Trades',
            'trades' => $trades,
            'allStatus' => $allStatus,
            'status' => $status
        ]);
    }

    public function tradeRequest()
    {
        $trades = Trade::where('user_2_id', Auth::id())
            ->get()
            ->map(function ($trade) {
                $trade->nextStatuses = $trade->getNextStatuses();
                return $trade;
            });

        $allStatus = Trade::STATUSES;

        return view('trade.tradeRequest', [
            'title' => 'Trade Request',
            'trades' => $trades,
            'allStatus' => $allStatus
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
        // Validate the incoming data
        $request->validate([
            'user_2_id' => 'required|exists:users,id', // The user you're trading with
            'book_1_id' => 'required|exists:books,id', // The book you're offering
            'book_2_id' => 'required|exists:books,id', // The book you're receiving
        ]);

        // Find the books by their IDs
        $book1 = Book::find($request->book_1_id); // The book you're offering
        $book2 = Book::find($request->book_2_id); // The book you're receiving

        // Check if both books are available for trade (stock > 0)
        if ($book1->stock <= 0 || $book2->stock <= 0) {
            session()->flash('alert', 'One or both books are unavailable for trade.');
            return redirect()->back();
        }

        // Create a new trade record in the trades table
        $trade = Trade::create([
            'user_1_id' => Auth::user()->id, // User initiating the trade
            'user_2_id' => $request->user_2_id, // User receiving the trade offer
            'book_2_id' => $request->book_2_id, // The book being received (offered by user_2)
            'trade_status' => 'Pending', // Default trade status
            'isPaid' => false, // Default payment status
            'isReceived' => false, // Default received status
        ]);

        // Now, store the book offered by user_1 (book_1) in the trade_books table
        DB::table('trade_books')->insert([
            'trade_id' => $trade->id, // Foreign key to the trade
            'book_id' => $book1->id, // The book that user_1 is offering
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Flash success message
        session()->flash('alert', 'Trade proposal sent.');

        // Redirect back or to a specific route
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Trade $trade)
    {
        return view('trade.detail', [
            'title' => 'Trade Detail',
            'trade' => $trade,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trade $trade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trade $trade)
    {
        // Validate input
        $request->validate([
            'user_2_id' => 'required|exists:users,id',
            'book_1_id' => 'required|exists:books,id',
            'book_2_id' => 'required|exists:books,id'
        ]);

        // Get the books
        $book1 = Book::findOrFail($request->book_1_id);
        $book2 = Book::findOrFail($request->book_2_id);

        // Check if books are available for trade (stock > 0)
        if ($book1->stock <= 0 || $book2->stock <= 0) {
            session()->flash('alert', 'One or both books are unavailable for trade.');
            return redirect()->back();
        }

        // Check if user_1 is the owner of the book they are offering (book_1_id)
        if ($book1->seller_id != Auth::user()->id) {
            session()->flash('alert', 'You can only offer books you own.');
            return redirect()->back();
        }

        // Check if user_2 is the owner of book_2_id (book they want to receive)
        $book2Owner = User::findOrFail($request->user_2_id);
        if ($book2Owner->id != $book2->seller_id) {
            session()->flash('alert', 'Book 2 must belong to the trade partner.');
            return redirect()->back();
        }

        // Proceed with updating the trade proposal and setting status to Pending
        $trade->update([
            'user_1_id' => Auth::user()->id,
            'user_2_id' => $request->user_2_id,
            'book_2_id' => $request->book_2_id,
            'trade_status' => 'Pending'
        ]);

        // Insert the offered book into trade_books (for tracking history)
        DB::table('trade_books')->insert([
            'trade_id' => $trade->id, // Foreign key to the trade
            'book_id' => $book1->id, // The book that user_1 is offering
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('alert', 'Trade proposal sent.');
        return redirect()->back();
    }

    public function updateStatus(Request $request, $tradeId)
    {
        $trade = Trade::findOrFail($tradeId);
        $newStatus = $request->choice;

        if ($newStatus === 'Accepted') {
            $book1Model = Book::find($trade->booksOffered->last()->id);
            $book1Model->stock -= 1;

            $book2Model = Book::find($trade->book_2_id);
            $book2Model->stock -= 1;

            $book1Model->save();
            $book2Model->save();
        } else if ( $newStatus === 'Cancelled' ) {
            $book1Model = Book::find($trade->booksOffered->last()->id);
            $book1Model->stock += 1;

            $book2Model = Book::find($trade->book_2_id);
            $book2Model->stock += 1;

            $book1Model->save();
            $book2Model->save();
        } else if ($newStatus === "Completed") {
            if (!$trade->isReceived) {
                $trade->isReceived = true;
                $trade->save();
                return redirect()->back()->with('success', 'Book has been received');
            }
        }

        if ($trade->transitionTo($newStatus)) {
            return redirect()->back()->with('success', 'Trade status updated.');
        }

        return redirect()->back()->with('error', 'Invalid status transition.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trade $trade)
    {
        //
    }
}
