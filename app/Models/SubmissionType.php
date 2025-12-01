<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmissionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'required_fields',
    ];

    protected $casts = [
        'required_fields' => 'array',
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
