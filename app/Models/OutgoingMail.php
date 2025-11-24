<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingMail extends Model
{
    protected $table = 'outgoing_mails';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'deskripsi',
        'file_dokumen',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];
}
