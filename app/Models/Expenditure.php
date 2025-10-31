<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'barangay',
        'category',
        'description',
        'amount',
        'date',
        'receipt',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Accessor for receipt URL
    public function getReceiptUrlAttribute()
    {
        return $this->receipt ? asset('storage/' . $this->receipt) : null;
    }
}
