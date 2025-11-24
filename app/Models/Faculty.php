<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // Relasi One-to-Many: Satu Fakultas punya banyak Program Studi
    public function studyPrograms(): HasMany
    {
        return $this->hasMany(StudyProgram::class);
    }

    // Relasi Polimorfik: Bisa menjadi 'borrower_unit' pada transaksi peminjaman
    public function borrowings()
    {
        return $this->morphMany(Borrowing::class, 'borrower_unit');
    }
}
