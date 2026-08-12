<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrowthMonitoring extends Model
{
    protected $fillable = [
        'infant_id',
        'date_measured',
        'age_in_months',
        'weight',
        'height',
        'head_circumference',
        'remarks',
    ];

    public function infant(): BelongsTo
    {
        return $this->belongsTo(Infant::class);
    }
}