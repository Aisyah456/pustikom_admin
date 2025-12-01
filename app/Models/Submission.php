<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit_id',
        'submission_type_id',
        'requester_name',
        'requester_email',
        'subject',
        'content',
        'attachments',
        'submission_date',
        'status',
        'current_stage',
        'reference_number',
        'verified_by',
        'verification_notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'submission_date' => 'date',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function type(): BelongsTo
    {
        // Menggunakan 'type' sebagai nama metode agar lebih deskriptif
        return $this->belongsTo(SubmissionType::class, 'submission_type_id');
    }

}
