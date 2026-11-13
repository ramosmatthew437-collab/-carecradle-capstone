<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PrenatalCheckup;



class Mother extends Model
{
   
protected $fillable = [
    'user_id',
    'profile_photo_path',
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

    // Father's Information
    'father_first_name',
    'father_middle_name',
    'father_last_name',
    'father_birth_date',
    'father_contact_number',
    'father_occupation',

    'philhealth_number',
    'height',
    'weight',
    'last_menstrual_period',
    'expected_delivery_date',
    'pregnancy_number',
    'status',
    'privacy_consent',
    'privacy_consent_at',
];


    /**
     * The login account of this mother.
     */
    /**
     * Days from the last menstrual period (LMP) to the expected delivery
     * date (EDD), using the standard 280-day (40-week) calculation.
     */
    public const PREGNANCY_DURATION_DAYS = 280;

    /**
     * Expected delivery date for an LMP, as Y-m-d (null when no LMP).
     * This is the single server-side source of the EDD calculation.
     */
    public static function calculateExpectedDeliveryDate(?string $lastMenstrualPeriod): ?string
    {
        if (blank($lastMenstrualPeriod)) {
            return null;
        }

        return \Illuminate\Support\Carbon::parse($lastMenstrualPeriod)
            ->startOfDay()
            ->addDays(self::PREGNANCY_DURATION_DAYS)
            ->toDateString();
    }

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
     * Infant registration eligibility (panel requirement, approved Rule A):
     * true when at least one actual prenatal checkup is recorded in
     * CareCradle with a visit date on or before today.
     *
     * - Checkups from any pregnancy count (eligibility never resets).
     * - Future-dated checkups do not count.
     * - Appointments never count, whatever their status.
     *
     * Uses the loaded prenatalCheckups relation when present (display),
     * otherwise queries the database (server-side enforcement).
     */
    public function hasQualifyingPrenatalCheckup(): bool
    {
        $today = today()->toDateString();

        if ($this->relationLoaded('prenatalCheckups')) {
            return $this->prenatalCheckups->contains(
                fn (PrenatalCheckup $checkup) => filled($checkup->visit_date)
                    && \Illuminate\Support\Carbon::parse($checkup->visit_date)->toDateString() <= $today
            );
        }

        return $this->prenatalCheckups()
            ->whereDate('visit_date', '<=', $today)
            ->exists();
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
 * Vaccination records of the mother.
 */
public function maternalVaccinations(): HasMany
{
    return $this->hasMany(MaternalVaccination::class);
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

    /*
    |--------------------------------------------------------------------------
    | Pregnancy status and referral
    |--------------------------------------------------------------------------
    | mothers.status is the PREGNANCY status: Pregnant or Delivered.
    | 'Referred' is kept only for older records saved before referrals were
    | tracked separately; for those the pregnancy status is unknown.
    | "Referred" is derived: an Active referral, or that legacy status.
    */

    public const PREGNANCY_STATUSES = ['Pregnant', 'Delivered'];

    public const LEGACY_REFERRED = 'Referred';

    /** Referral history, newest first. */
    public function referrals(): HasMany
    {
        return $this->hasMany(MotherReferral::class)->orderByDesc('referred_at')->orderByDesc('id');
    }

    public function activeReferral(): HasOne
    {
        return $this->hasOne(MotherReferral::class)->ofMany(['id' => 'max'], fn ($q) => $q->where('status', MotherReferral::ACTIVE));
    }

    /** Mothers who are currently referred (active referral or legacy status). */
    public function scopeReferred(Builder $query): Builder
    {
        return $query->where(fn ($q) => $q->where('status', self::LEGACY_REFERRED)
            ->orWhereHas('referrals', fn ($r) => $r->where('status', MotherReferral::ACTIVE)));
    }

    public function isLegacyReferred(): bool
    {
        return $this->status === self::LEGACY_REFERRED;
    }

    public function isReferred(): bool
    {
        if ($this->isLegacyReferred()) {
            return true;
        }

        if (array_key_exists('has_active_referral', $this->attributes)) {
            return (bool) $this->attributes['has_active_referral'];
        }

        return $this->relationLoaded('activeReferral')
            ? $this->activeReferral !== null
            : $this->referrals()->where('status', MotherReferral::ACTIVE)->exists();
    }

    /** Pregnancy status for display: Pregnant, Delivered, or "Unknown" for the legacy value. */
    public function pregnancyStatusLabel(): string
    {
        return $this->isLegacyReferred() ? 'Unknown' : (string) $this->status;
    }

    /** Query helper: adds has_active_referral (0/1) without loading referrals. */
    public function scopeWithReferralFlag(Builder $query): Builder
    {
        return $query->withExists(['referrals as has_active_referral' => fn ($r) => $r->where('status', MotherReferral::ACTIVE)]);
    }

   

    
    
}


