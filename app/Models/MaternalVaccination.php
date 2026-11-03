<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaternalVaccination extends Model
{
    protected $fillable = [
        'mother_id',
        'vaccine_name',
        'dose',
        'date_given',
        'next_due_date',
        'administered_by',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date_given' => 'date',
            'next_due_date' => 'date',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}