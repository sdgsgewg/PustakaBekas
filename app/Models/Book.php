<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Book extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['category', 'genres', 'seller'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function genres() 
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }
    
    public function seller() 
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_books')
        ->withPivot('quantity', 'isChecked')
        ->withTimestamps();
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_books')
        ->withPivot('id', 'quantity', 'sub_total_price')
        ->withTimestamps();
    }

    public function trades()
    {
        return $this->belongsToMany(Trade::class, 'trade_books');
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id', 'id');
    }

    public function reviewByUser($userId)
    {
        return $this->reviews()->where('user_id', $userId)->first();
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function scopeBooksWithinPriceRange($query, $sellerId, $targetPrice, $percentage = 0.1)
    {
        $lowerBound = $targetPrice * (1 - $percentage);
        $upperBound = $targetPrice * (1 + $percentage);
        $zero = 0;

        return $query->where('seller_id', $sellerId)
                    ->where('stock', '>', $zero)
                    ->whereBetween('price', [$lowerBound, $upperBound]);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
