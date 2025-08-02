<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_code',
        'book_id',
        'member_id',
        'user_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
        'fine_amount'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate borrow code
    public static function generateBorrowCode()
    {
        $lastBorrow = self::latest('id')->first();
        $number = $lastBorrow ? $lastBorrow->id + 1 : 1;
        return 'BRW' . date('Ymd') . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Check if overdue
    public function isOverdue()
    {
        return $this->status === 'borrowed' && Carbon::now()->gt($this->due_date);
    }

    // Calculate fine
    public function calculateFine($dailyFine = 1000)
    {
        if ($this->status === 'returned' && $this->return_date && $this->return_date->gt($this->due_date)) {
            $overdueDays = $this->return_date->diffInDays($this->due_date);
            return $overdueDays * $dailyFine;
        }
        
        if ($this->isOverdue()) {
            $overdueDays = Carbon::now()->diffInDays($this->due_date);
            return $overdueDays * $dailyFine;
        }

        return 0;
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where('borrow_code', 'like', "%{$search}%")
                    ->orWhereHas('member', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('member_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('book', function($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
    }

    // Scope for status filter
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}