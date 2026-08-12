<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrenatalCheckup extends Model
{
    protected $fillable = [
        'mother_id',
        'visit_date',
        'gestational_age_weeks',
        'weight',
        'systolic_bp',
        'diastolic_bp',
        'fundal_height',
        'fetal_heart_rate',
        'fetal_movement',
        'urine_protein',
        'urine_glucose',
        'maternal_condition',
        'notes',
        'next_visit_date',
    ];

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}