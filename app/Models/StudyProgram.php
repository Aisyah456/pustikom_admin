<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_id', 'name', 'code'];

    // Relasi Inverse One-to-Many: Program Studi dimiliki oleh satu Fakultas
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    // Relasi Polimorfik: Bisa menjadi 'borrower_unit' pada transaksi peminjaman
    public function borrowings()
    {
        return $this->morphMany(Borrowing::class, 'borrower_unit');
    }
}
