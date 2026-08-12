<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [

        'mother_id',

        'appointment_type',

        'appointment_date',

        'appointment_time',

        'status',

        'notes',

    ];

    /**
     * Appointment belongs to one mother.
     */
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}