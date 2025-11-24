<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // Relasi Polimorfik: Bisa menjadi 'borrower_unit' pada transaksi peminjaman
    public function borrowings()
    {
        return $this->morphMany(Borrowing::class, 'borrower_unit');
    }
}
