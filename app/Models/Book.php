<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Book extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['category', 'genres', 'seller'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                 $query->where('title', 'like', '%' . $search . '%')
             )
         );

         $query->when($filters['category'] ?? false, function($query, $category) {
            return $query->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when( $filters['genre'] ?? false, function($query, $genre) {
            return $query->whereHas('genres', function($query) use ($genre) {
                $query->where('slug', $genre);
            });
        });

        $query->when( $filters['seller'] ?? false, fn($query, $seller) => 
            $query->whereHas('seller', fn($query) => 
                $query->where('username', $seller)
            )
        );
    }

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
        ->withPivot('quantity', 'sub_total_price')
        ->withTimestamps();
    }

    public function trades()
    {
        return $this->belongsToMany(Trade::class, 'trade_books');
    }

    public function scopeBooksWithinPriceRange($query, $sellerId, $targetPrice, $percentage = 0.1)
    {
        $lowerBound = $targetPrice * (1 - $percentage);
        $upperBound = $targetPrice * (1 + $percentage);

        return $query->where('seller_id', $sellerId)
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
