<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrenatalCheckupAttachment extends Model
{
    protected $fillable = [
        'prenatal_checkup_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function prenatalCheckup(): BelongsTo
    {
        return $this->belongsTo(PrenatalCheckup::class);
    }
}