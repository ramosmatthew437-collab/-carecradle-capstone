<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsNotification extends Model
{
    protected $fillable = [

        'mother_id',

        'appointment_id',

        'recipient_number',

        'message',

        'notification_type',

        'status',

        'sent_at',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}