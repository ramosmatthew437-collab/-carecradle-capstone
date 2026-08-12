<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PrenatalCheckup;



class Mother extends Model
{
    protected $fillable = [
        'user_id',
        'mother_code',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'contact_number',
        'address',
        'barangay',
        'blood_type',
        'civil_status',
        'occupation',
        'philhealth_number',
        'height',
        'weight',
        'last_menstrual_period',
        'expected_delivery_date',
        'pregnancy_number',
        'status',
    ];

    /**
     * The login account of this mother.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Prenatal checkups of the mother.
     */
    public function prenatalCheckups(): HasMany
    {
        return $this->hasMany(PrenatalCheckup::class);
    }

    /**
     * Appointments of the mother.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Infants of the mother.
     */
    public function infants(): HasMany
    {
        return $this->hasMany(Infant::class);
    }

    /**
     * Medical logs of the mother.
     */
    public function medicalLogs(): HasMany
    {
        return $this->hasMany(MedicalLog::class);
    }

    /**
     * SMS notifications sent to the mother.
     */
    public function smsNotifications(): HasMany
    {
        return $this->hasMany(SmsNotification::class);
    }

   

    
    
}


