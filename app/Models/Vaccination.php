<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    protected $fillable = [
        'infant_id',
        'vaccine_name',
        'dose',
        'date_given',
        'next_due_date',
        'administered_by',
        'remarks',
    ];

    public function infant(): BelongsTo
    {
        return $this->belongsTo(Infant::class);
    }
}