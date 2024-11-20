<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;

    protected $table = 'book_reviews';
    protected $guarded = ['id'];

    // Relationship with Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
