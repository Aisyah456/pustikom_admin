<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_name',
        'borrower_unit_id',
        'borrower_unit_type',
        'item_id',
        'borrow_date',
        'estimated_return_date',
        'purpose',
        'quantity',
        'condition_out',
        'status',
        'actual_return_date',
        'condition_in',
        'notes',
        'admin_out',
        'admin_in',
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'estimated_return_date' => 'datetime',
        'actual_return_date' => 'datetime',
    ];

    // Relasi Inverse One-to-Many: Peminjaman ini milik satu Item
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi Polimorfik: Menentukan apakah peminjamnya adalah Unit, Fakultas, atau Program Studi
    public function borrowerUnit(): MorphTo
    {
        return $this->morphTo();
    }
}
