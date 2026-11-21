<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Vaccination extends Model
{
    /**
     * Approved infant vaccine schedule: the single source of truth for the
     * vaccine and dose suggestions, the age guidance shown in the forms, and
     * server-side validation of standard selections.
     *
     * PROPOSED configuration, pending Irosin RHU confirmation. Ages are
     * guidance only: they are never used to restrict or calculate dates, so
     * late and catch-up doses are recorded with the actual date given.
     *
     * - doses:        standard dose label => recommended age
     * - custom_doses: whether a custom dose label may be recorded for this
     *                 vaccine (BCG: Birth Dose only, as before)
     *
     * Vaccine or dose text outside this list is a custom value: stored
     * exactly as entered, with no schedule or dose meaning attached.
     */
    public const SCHEDULE = [
        'BCG' => ['doses' => ['Birth Dose' => 'at birth'], 'custom_doses' => false],
        'Hepatitis B' => ['doses' => ['Birth Dose' => 'at birth'], 'custom_doses' => true],
        'Pentavalent' => ['doses' => ['1st Dose' => 'at 1½ months', '2nd Dose' => 'at 2½ months', '3rd Dose' => 'at 3½ months'], 'custom_doses' => true],
        'OPV' => ['doses' => ['1st Dose' => 'at 1½ months', '2nd Dose' => 'at 2½ months', '3rd Dose' => 'at 3½ months'], 'custom_doses' => true],
        'IPV' => ['doses' => ['1st Dose' => 'at 3½ months', '2nd Dose' => 'at 9 months'], 'custom_doses' => true],
        'PCV' => ['doses' => ['1st Dose' => 'at 1½ months', '2nd Dose' => 'at 2½ months', '3rd Dose' => 'at 3½ months'], 'custom_doses' => true],
        'MMR' => ['doses' => ['1st Dose' => 'at 9 months', '2nd Dose' => 'at 12 months'], 'custom_doses' => true],
    ];

    public const SCHEDULE_NOTE = 'Proposed schedule, pending Irosin RHU confirmation.';

    /*
    |--------------------------------------------------------------------------
    | Automatic next-dose scheduling (architecture only: DISABLED)
    |--------------------------------------------------------------------------
    |
    | When enabled, the Next Due Date of a standard dose is calculated from the
    | ACTUAL date the dose was given, using the rule for that vaccine and dose:
    |
    |   NEXT_DOSE_RULES['Vaccine']['Dose just given'] = [
    |       'min_days_after' => int|null,  // days after this dose's Date Given
    |       'min_age_days'   => int|null,  // infant's minimum age for the next dose
    |   ]
    |
    | Next due date = the later of (date given + min_days_after) and
    | (birth date + min_age_days); missing parts are ignored. The final standard
    | dose of a vaccine never gets a next due date. Custom vaccines and custom
    | doses are never calculated. A Next Due Date typed by the Midwife is
    | always kept.
    |
    | Intentionally EMPTY and switched OFF until the Irosin RHU confirms the
    | official intervals. No clinical interval is assumed anywhere.
    */
    public const AUTO_SCHEDULING_ENABLED = false;

    public const NEXT_DOSE_RULES = [];

    public const AUTO_SCHEDULING_PENDING_NOTE = 'Automatic next-dose scheduling is awaiting Irosin RHU confirmation of the official vaccine intervals. Enter the next due date manually.';

    /** True only when scheduling is switched on AND at least one approved rule exists. */
    public static function autoSchedulingActive(): bool
    {
        return static::AUTO_SCHEDULING_ENABLED && static::NEXT_DOSE_RULES !== [];
    }

    /** The standard dose after $dose for an approved vaccine; null for the final or a non-standard dose. */
    public static function nextStandardDose(?string $vaccine, ?string $dose): ?string
    {
        $doses = self::dosesFor($vaccine);
        $index = array_search((string) $dose, $doses, true);

        return $index === false ? null : ($doses[$index + 1] ?? null);
    }

    /**
     * Next due date (Y-m-d) for a standard dose given on $dateGiven, or null when
     * scheduling is not active, the vaccine/dose is custom, it is the final
     * dose, or no approved rule exists for this vaccine and dose.
     */
    public static function calculateNextDueDate(?string $vaccine, ?string $dose, mixed $dateGiven, mixed $birthDate = null): ?string
    {
        if (! static::autoSchedulingActive() || blank($dateGiven)
            || ! self::isStandardDose($vaccine, $dose) || self::nextStandardDose($vaccine, $dose) === null) {
            return null;
        }

        $rule = static::NEXT_DOSE_RULES[(string) $vaccine][(string) $dose] ?? null;

        if (! is_array($rule)) {
            return null;
        }

        $candidates = [];

        if (isset($rule['min_days_after']) && is_int($rule['min_days_after'])) {
            $candidates[] = Carbon::parse($dateGiven)->startOfDay()->addDays($rule['min_days_after']);
        }

        if (isset($rule['min_age_days']) && is_int($rule['min_age_days']) && filled($birthDate)) {
            $candidates[] = Carbon::parse($birthDate)->startOfDay()->addDays($rule['min_age_days']);
        }

        if ($candidates === []) {
            return null;
        }

        return collect($candidates)->max()->toDateString();
    }

    /*
    |--------------------------------------------------------------------------
    | Doses already given (from saved records only)
    |--------------------------------------------------------------------------
    */

    /**
     * Standard doses already recorded for an infant, as
     * ['Approved vaccine' => ['Standard dose' => 'Y-m-d date given']].
     * Stored text that differs from an approved vaccine or standard dose only
     * in letter case or spacing counts as that vaccine/dose. Custom vaccines
     * and custom doses are not included. $excludeId leaves out the record
     * being edited, so its own dose stays selectable.
     */
    public static function administeredStandardDoses(int $infantId, ?int $excludeId = null): array
    {
        $given = [];

        $records = self::query()
            ->where('infant_id', $infantId)
            ->when($excludeId, fn ($q) => $q->whereKeyNot($excludeId))
            ->orderBy('date_given')
            ->orderBy('id')
            ->get(['id', 'vaccine_name', 'dose', 'date_given']);

        foreach ($records as $record) {
            $vaccine = self::approvedVaccineMatching($record->vaccine_name);
            $dose = $vaccine ? self::standardDoseMatching($vaccine, $record->dose) : null;

            if ($vaccine && $dose && ! isset($given[$vaccine][$dose])) {
                $given[$vaccine][$dose] = Carbon::parse($record->date_given)->toDateString();
            }
        }

        return $given;
    }

    /** Maximum lengths for new or changed vaccine and dose text. */
    public const VACCINE_MAX = 100;
    public const DOSE_MAX = 50;

    /** Approved vaccine names, in display order. */
    public static function vaccineNames(): array
    {
        return array_keys(self::SCHEDULE);
    }

    /** Standard doses of an approved vaccine (empty for a custom vaccine). */
    public static function dosesFor(?string $vaccine): array
    {
        return array_keys(self::doseGuidance($vaccine));
    }

    /** Standard dose => recommended age, for an approved vaccine (empty otherwise). */
    public static function doseGuidance(?string $vaccine): array
    {
        return self::SCHEDULE[(string) $vaccine]['doses'] ?? [];
    }

    public static function isApprovedVaccine(?string $vaccine): bool
    {
        return array_key_exists((string) $vaccine, self::SCHEDULE);
    }

    public static function isStandardDose(?string $vaccine, ?string $dose): bool
    {
        return array_key_exists((string) $dose, self::doseGuidance($vaccine));
    }

    /** Custom dose labels are allowed for custom vaccines and for approved vaccines that permit them. */
    public static function allowsCustomDose(?string $vaccine): bool
    {
        return ! self::isApprovedVaccine($vaccine) || self::SCHEDULE[$vaccine]['custom_doses'];
    }

    /**
     * The approved vaccine that a typed name stands for when it differs only
     * in letter case or spacing (e.g. "bcg", "Hepatitis  B"), else null.
     */
    public static function approvedVaccineMatching(?string $text): ?string
    {
        $key = self::normalisedVaccineName($text);

        foreach (self::vaccineNames() as $name) {
            if (self::normalisedVaccineName($name) === $key) {
                return $name;
            }
        }

        return null;
    }

    /** The standard dose of $vaccine that a typed label stands for (case/spacing only), else null. */
    public static function standardDoseMatching(?string $vaccine, ?string $text): ?string
    {
        $key = self::normalisedVaccineName($text);

        foreach (self::dosesFor($vaccine) as $dose) {
            if (self::normalisedVaccineName($dose) === $key) {
                return $dose;
            }
        }

        return null;
    }

    /** True when this record's vaccine is not in the approved schedule. */
    public function isCustomVaccine(): bool
    {
        return ! self::isApprovedVaccine($this->vaccine_name);
    }

    /** True when this record's dose is not a standard dose of its vaccine. */
    public function isCustomDose(): bool
    {
        return ! self::isStandardDose($this->vaccine_name, $this->dose);
    }

    /**
     * Vaccine name compared the same way as the Midwife Dashboard
     * (DashboardController::pastDueDoseQuery): case-insensitive, spaces ignored.
     */
    public static function normalisedVaccineName(?string $name): string
    {
        return mb_strtolower(str_replace(' ', '', (string) $name));
    }

    /**
     * True when the same infant has a later record of the same vaccine: given
     * on a later date, or on the same date but recorded afterwards (higher id).
     * Mirrors the "not followed by a later dose" rule of the Midwife Dashboard.
     *
     * @param  iterable<Vaccination>  $records  the infant's vaccination records
     */
    public function isSupersededWithin(iterable $records): bool
    {
        $name = self::normalisedVaccineName($this->vaccine_name);
        $given = Carbon::parse($this->date_given)->toDateString();

        foreach ($records as $other) {
            if ((int) $other->id === (int) $this->id
                || (int) $other->infant_id !== (int) $this->infant_id
                || self::normalisedVaccineName($other->vaccine_name) !== $name) {
                continue;
            }

            $otherGiven = Carbon::parse($other->date_given)->toDateString();

            if ($otherGiven > $given || ($otherGiven === $given && (int) $other->id > (int) $this->id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Next-due status, using the Midwife Dashboard's rules:
     * - 'overdue'    next due date is before today and no later dose of the
     *                same vaccine has been recorded;
     * - 'upcoming'   next due date is today or later (due today is not overdue);
     * - 'superseded' next due date has passed but a later dose was recorded;
     * - null         no next due date.
     *
     * @param  iterable<Vaccination>  $records  the infant's vaccination records
     */
    public function dueStatus(iterable $records, ?Carbon $today = null): ?string
    {
        if (blank($this->next_due_date)) {
            return null;
        }

        $today = ($today ?? Carbon::today())->toDateString();
        $due = Carbon::parse($this->next_due_date)->toDateString();

        if ($due >= $today) {
            return 'upcoming';
        }

        return $this->isSupersededWithin($records) ? 'superseded' : 'overdue';
    }

    protected $fillable = [
        'infant_id',
        'vaccine_name',
        'dose',
        'date_given',
        'next_due_date',
        'administered_by',
        'remarks',
    ];

    public function infant(): BelongsTo
    {
        return $this->belongsTo(Infant::class);
    }
}