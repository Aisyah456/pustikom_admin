<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLoan extends Model
{
    use HasFactory;

    protected $table = 'item_loans';

    protected $fillable = [
        'nama_peminjam',
        'nip',
        'no_hp',
        'program_studi',
        'fakultas',
        'biro',
        'nama_barang',
        'jumlah',
        'image',
        'keperluan',
        'tanggal_pinjam',
        'jam_peminjaman',
        'tanggal_kembali',
        'jam_pengembalian',
        'yang_menyerahkan',
        'penerima_barang',
        'status',
        'lampiran',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'jam_peminjaman' => 'datetime:H:i',
        'jam_pengembalian' => 'datetime:H:i',
        'jumlah' => 'integer',
    ];

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pending</span>',
            'dipinjam' => '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Dipinjam</span>',
            'selesai' => '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Selesai</span>',
            default => '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">' . ucfirst($this->status) . '</span>',
        };
    }
}
