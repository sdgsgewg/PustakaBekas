<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';
    protected $guarded = ['id'];
    protected $with = ['user1', 'user2', 'book2'];

    const STATUSES = [
        'Pending',
        'Accepted',
        'Declined',
        'In Progress',
        'Completed',
        'Cancelled',
    ];

    protected static $allowedTransitions = [
        'Pending' => ['Declined', 'Accepted'],
        'Accepted' => ['Cancelled', 'In Progress'],
        'Declined' => ['Cancelled', 'Pending'],
        'In Progress' => ['Cancelled', 'Completed'],
        'Completed' => [],
        'Cancelled' => [],
    ];

    // Method to check if a status transition is allowed
    public function canTransitionTo($newStatus)
    {
        return in_array($newStatus, static::$allowedTransitions[$this->trade_status] ?? []);
    }

    // Method to update the status if allowed
    public function transitionTo($newStatus)
    {
        if ($this->canTransitionTo($newStatus)) {
            $this->trade_status = $newStatus;
            return $this->save();
        }

        return false;
    }

    public function getNextStatuses()
    {
        return static::$allowedTransitions[$this->trade_status] ?? [];
    }

    public function user1()
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }

    public function booksOffered()
    {
        return $this->belongsToMany(Book::class, 'trade_books');
    }

    // public function latestOfferedBook()
    // {
    //     return $this->booksOffered()->latest()->first();
    // }

    public function book2()
    {
        return $this->belongsTo(Book::class, 'book_2_id');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function updateStatus($newStatus)
    {
        $this->tradeStatus = $newStatus;
        $this->save();
    }
}
