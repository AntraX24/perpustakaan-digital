<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'description',
        'cover',
        'stock',
        'available',
        'publication_year',
        'publisher'
    ];

    protected $casts = [
        'publication_year' => 'integer',
    ];

    // Relationship with borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // Get active borrowings
    public function activeBorrowings()
    {
        return $this->hasMany(Borrowing::class)->whereIn('status', ['approved', 'borrowed']);
    }

    // Check if book is available
    public function isAvailable()
    {
        return $this->available > 0;
    }

    // Get cover URL
    public function getCoverUrlAttribute()
    {
        if ($this->cover) {
            return asset('storage/' . $this->cover);
        }
        return asset('images/no-cover.jpg');
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
    }

    // Scope for category filter
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}