<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_Book extends Model
{
    use HasFactory;

    protected $table = 'transaction_books';
    protected $guarded = ['id'];
    protected $with = ['transaction', 'book'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function updateStatus($newStatus)
    {
        $this->transactionStatus = $newStatus;
        $this->save();
    }

}
