<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $guarded = ['id'];
    protected $with = ['buyer' , 'seller'];

    const STATUSES = [
        // 'Not Paid',
        'Pending',
        'Accepted',
        'Delivered',
        // 'Returned',
        'Completed',
        'Cancelled',
    ];

    protected static $allowedTransitions = [
        'Not Paid' => ['Pending', 'Cancelled'],
        'Pending' => ['Cancelled', 'Accepted'],
        'Accepted' => ['Cancelled', 'Delivered'],
        'Delivered' => ['Returned', 'Completed'],
        'Returned' => ['Refunded', 'Closed'],
        'Completed' => [],
        'Cancelled' => [],
    ];

    // Method to check if a status transition is allowed
    public function canTransitionTo($newStatus)
    {
        return in_array($newStatus, static::$allowedTransitions[$this->transaction_status] ?? []);
    }

    // Method to update the status if allowed
    public function transitionTo($newStatus)
    {
        if ($this->canTransitionTo($newStatus)) {
            $this->transaction_status = $newStatus;
            return $this->save();
        }

        return false;
    }

    public function getNextStatuses()
    {
        return static::$allowedTransitions[$this->transaction_status] ?? [];
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'transaction_books')
                    ->withPivot('quantity', 'sub_total_price')
                    ->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function updateStatus($newStatus)
    {
        $this->transactionStatus = $newStatus;
        $this->save();
    }

}
