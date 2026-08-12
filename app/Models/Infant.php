<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vaccination;


class Infant extends Model
{
    protected $fillable = [
        'mother_id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'birth_weight',
        'birth_length',
        'head_circumference',
        'birth_status',
        'remarks',
    ];
    public function growthMonitorings(): HasMany
{
     return $this->hasMany(GrowthMonitoring::class)
                ->orderByDesc('date_measured');
}

    /**
     * Get the mother who owns this infant.
     */
    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }
    


    public function vaccinations(): HasMany
{
    return $this->hasMany(Vaccination::class)
                ->orderByDesc('date_given');
}
}