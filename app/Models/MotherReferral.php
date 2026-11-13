<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * A referral of a mother to another facility.
 *
 * status:
 * - Active:           the mother is currently referred.
 * - Closed:           follow-up recorded; the referral is finished.
 * - Entered in error: recorded by mistake; kept for the audit trail.
 *
 * A referral never changes the mother's pregnancy status, account, records,
 * appointments or SMS reminders.
 */
class MotherReferral extends Model
{
    public const ACTIVE = 'Active';
    public const CLOSED = 'Closed';
    public const VOIDED = 'Entered in error';

    protected $fillable = [
        'mother_id', 'referred_at', 'reason', 'receiving_facility', 'referred_by', 'referred_by_name', 'notes',
        'status', 'outcome_at', 'outcome_notes', 'outcome_source',
        'closed_at', 'closed_by', 'closed_by_name',
        'voided_reason', 'voided_at', 'voided_by', 'voided_by_name',
    ];

    protected $casts = [
        'referred_at' => 'date',
        'outcome_at' => 'date',
        'closed_at' => 'datetime',
        'voided_at' => 'datetime',
    ];

    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::ACTIVE);
    }

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }
}
