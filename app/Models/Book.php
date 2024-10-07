<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Book extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['genre', 'seller'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                 $query->where('title', 'like', '%' . $search . '%');
             });
         });

        $query->when( $filters['genre'] ?? false, function($query, $genre) {
            return $query->whereHas('genre', function($query) use ($genre) {
                $query->where('slug', $genre);
            });
        });

        $query->when( $filters['seller'] ?? false, fn($query, $seller) => 
            $query->whereHas('seller', fn($query) => 
                $query->where('username', $seller)
            )
        );
    }

    public function genre() 
    {
        return $this->belongsTo(Genre::class);
    }

    public function seller() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_books')
        ->withPivot('quantity')
        ->withTimestamps();
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
