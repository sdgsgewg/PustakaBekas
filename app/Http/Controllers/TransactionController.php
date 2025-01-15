<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Transaction_Book;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('seller', 'books')
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($transaction) {
                $transaction->nextStatuses = $transaction->getNextStatuses();
                return $transaction;
            });

        $status = Transaction::select('transaction_status')->distinct()->pluck('transaction_status')->toArray();;

        $allStatus = Transaction::STATUSES;

        // Calculate transaction count per status
        $numTransactionByStatus = [];
        foreach ($allStatus as $status) {
            $numTransactionByStatus[$status] = $transactions->where('transaction_status', $status)->count();
        }
    
        $selectedStatus = session('selectedStatus', 'Completed');
        session()->forget('selectedStatus');

        return view('transaction.index', [
            'title' => 'My Orders',
            'transactions' => $transactions,
            'allStatus' => $allStatus,
            'status' => $status,
            'selectedStatus' => $selectedStatus,
            'numTransactionByStatus' => $numTransactionByStatus,
        ]);
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.detail', [
            'title' => 'Transaction Detail',
            'transaction' => $transaction,
        ]);
    }

    public function orderRequest()
    {
        $transactions = Transaction::with('buyer', 'books')
            ->where('seller_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($transaction) {
                $transaction->nextStatuses = $transaction->getNextStatuses();
                return $transaction;
            });

        $allStatus = Transaction::STATUSES;

        // Calculate transaction count per status
        $numTransactionByStatus = [];
        foreach ($allStatus as $status) {
            $numTransactionByStatus[$status] = $transactions->where('transaction_status', $status)->count();
        }

        $selectedStatus = session('selectedStatus', 'Pending');
        session()->forget('selectedStatus');

        return view('transaction.orderRequest', [
            'title' => 'Order Request',
            'transactions' => $transactions,
            'allStatus' => $allStatus,
            'selectedStatus' => $selectedStatus,
            'numTransactionByStatus' => $numTransactionByStatus,
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
    public function store(StoreTransactionRequest $request)
    {
        $request->validate([
            'paymentMethod' => 'required|string',
        ]);

        $checkoutItems = json_decode($request->checkoutItems, true);

        $bookIds = [];

        foreach ($checkoutItems as $sellerId => $sellerGroup) {
            
            $transaction = Transaction::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $sellerId,
                'total_price' => $request->subTotalPrice,
                'shipping_fee' => $request->shippingFee,
                'service_fee' => $request->serviceFee,
                'grand_total_price' => $request->totalPrice,
                'payment_method' => $request->paymentMethod,
                'transaction_status' => 'Pending'
            ]);

            $transaction->payment_time = now();
            $transaction->order_number = 'TX-' . now()->format('Ymd') . '-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT);
            $transaction->save();

            foreach ($sellerGroup['items'] as $book) {
                if (!isset($book['pivot']['quantity'])) {
                    return redirect()->back()->withErrors(['quantity' => 'Quantity is missing for some books.']);
                }

                $quantity = $book['pivot']['quantity'];
                $bookModel = Book::find($book['id']);

                $bookModel['stock'] -= $quantity;
                $bookModel->save();

                Transaction_Book::create([
                    'transaction_id' => $transaction->id,
                    'book_id' => $book['id'],
                    'quantity' => $quantity,
                    'sub_total_price' => $book['price'] * $quantity,
                ]);

                $bookIds[] = $book['id'];
            }
        }

        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->books()->detach($bookIds);
        }

        session(['selectedStatus' => 'Pending']);

        return redirect()->route('transactions.index')->with('success', 'Order created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    public function updateStatus(UpdateTransactionRequest $request, $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $newStatus = $request->choice;

        if($newStatus === "Delivered") {
            $transaction->shipping_time = now();
            $transaction->save();
        } else if ( in_array( $newStatus, ['Returned', 'Cancelled'] ) ) {
            foreach( $transaction->books as $book ){
                $bookModel = Book::find($book->id);
                $bookModel->stock += $book->pivot->quantity;
                $bookModel->save();
            }
        } else if ($newStatus === "Completed") {
            if (!$transaction->isReceived) {
                $transaction->isReceived = true;
                $transaction->save();

                session(['selectedStatus' => 'Delivered']);

                return redirect()->back()->with('success', 'Order has been received');
            } else {
                $transaction->completion_time = now();
                $transaction->save();
            }
        }

        session(['selectedStatus' => $newStatus]);

        if ($transaction->transitionTo($newStatus)) {
            return redirect()->back()->with('success', 'Transaction status updated.');
        }

        return redirect()->back()->with('error', 'Invalid status transition.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
