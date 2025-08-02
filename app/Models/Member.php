<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'email',
        'phone',
        'address',
        'join_date',
        'status'
    ];

    protected $casts = [
        'join_date' => 'date',
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

    // Generate member number
    public static function generateMemberNumber()
    {
        $lastMember = self::latest('id')->first();
        $number = $lastMember ? $lastMember->id + 1 : 1;
        return 'MEM' . date('Y') . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('member_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
    }

    // Check if member is active
    public function isActive()
    {
        return $this->status === 'active';
    }
}