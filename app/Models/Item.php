<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'specification',
        'total_stock',
        'current_stock',
        'location',
        'status',
    ];

    // Relasi One-to-Many: Satu Item bisa muncul di banyak transaksi peminjaman
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
