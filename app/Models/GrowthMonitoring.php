<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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

    /**
     * Completed months of age on the measurement date (the authoritative
     * calculation for age_in_months). A month is complete on the same day of
     * a later month, or on that month's last day when it is shorter (born
     * Jan 31 -> 1 month on Feb 28). Returns null when either date is missing
     * or the measurement is before the birth.
     */
    public static function completedMonths(mixed $birthDate, mixed $measuredOn): ?int
    {
        if (blank($birthDate) || blank($measuredOn)) {
            return null;
        }

        $birth = Carbon::parse($birthDate)->startOfDay();
        $measured = Carbon::parse($measuredOn)->startOfDay();

        if ($measured->lt($birth)) {
            return null;
        }

        $months = ($measured->year - $birth->year) * 12 + ($measured->month - $birth->month);

        if ($birth->copy()->addMonthsNoOverflow($months)->gt($measured)) {
            $months--;
        }

        return max(0, $months);
    }
}
