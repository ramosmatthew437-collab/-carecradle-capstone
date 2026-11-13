<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class MaternalVaccination extends Model
{
    /**
     * Approved maternal vaccine names (RHU-provided). Single source of truth
     * for the form options and server-side validation. Stored values are
     * these exact strings.
     */
    public const VACCINES = [
        'Tetanus-diphtheria (Td)',
        'Tetanus toxoid (TT)',
    ];

    /** Notes shown beside an option in the form (not stored). */
    public const VACCINE_NOTES = [
        'Tetanus toxoid (TT)' => 'Only when TT is in stock',
    ];

    /** Approved dose labels (RHU-provided). No interval rules are implied. */
    public const DOSES = [
        'Dose 1',
        'Dose 2',
        'Dose 3',
        'Dose 4',
        'Dose 5',
    ];

    /**
     * RHU-confirmed: Td and TT share ONE dose series (Dose 1 -> Dose 5), and
     * the series belongs to the mother: it continues across pregnancies and
     * is never reset by a new pregnancy or infant (records have no pregnancy
     * link, so her whole history is always used).
     *
     * Returns the next eligible dose for a mother: the dose after the highest
     * dose recorded across her Td and TT records, "Dose 1" when there are
     * none, or null when Dose 5 has been recorded (series complete).
     *
     * Only records with an approved vaccine name AND an approved dose label
     * count; legacy records (e.g. "Maternal Vaccine", "MPV", or non-standard
     * dose labels) are not treated as Td/TT history. Pass $excludeId to leave
     * out the record being edited. No dates or intervals are involved.
     */
    public static function nextEligibleDose(int $motherId, ?int $excludeId = null): ?string
    {
        $highest = static::seriesRecords($motherId, $excludeId)
            ->map(fn (self $record) => array_search($record->dose, self::DOSES, true))
            ->max();

        return self::DOSES[$highest === null ? 0 : $highest + 1] ?? null;
    }

    /** The mother's records that belong to the shared Td/TT series. */
    public static function seriesRecords(int $motherId, ?int $excludeId = null)
    {
        return static::query()
            ->where('mother_id', $motherId)
            ->when($excludeId, fn ($query) => $query->whereKeyNot($excludeId))
            ->get(['id', 'vaccine_name', 'dose'])
            ->filter(fn (self $record) => $record->isSeriesRecord())
            ->values();
    }

    /** True when this record counts toward the shared Td/TT series. */
    public function isSeriesRecord(): bool
    {
        return in_array($this->vaccine_name, self::VACCINES, true)
            && in_array($this->dose, self::DOSES, true);
    }

    /**
     * True when the same mother has a later record that closes this dose's
     * next due date: given on a later date, or on the same date but recorded
     * afterwards (higher id), as in Vaccination::isSupersededWithin().
     *
     * - Td/TT series records: any later series record counts, because Td and
     *   TT share ONE dose series (see nextEligibleDose()).
     * - Other (legacy/custom) records: a later record of the same vaccine,
     *   compared case-insensitively ignoring spaces (the dashboard rule).
     *
     * Presentation helper only: no dates or intervals are calculated.
     *
     * @param  iterable<MaternalVaccination>  $records  the mother's maternal records
     */
    public function isSupersededWithin(iterable $records): bool
    {
        $series = $this->isSeriesRecord();
        $name = Vaccination::normalisedVaccineName($this->vaccine_name);
        $given = Carbon::parse($this->date_given)->toDateString();

        foreach ($records as $other) {
            if ((int) $other->id === (int) $this->id || (int) $other->mother_id !== (int) $this->mother_id) {
                continue;
            }

            $sameLine = $series
                ? $other->isSeriesRecord()
                : Vaccination::normalisedVaccineName($other->vaccine_name) === $name;

            if (! $sameLine) {
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
     * Next-due status with the same meaning as Vaccination::dueStatus():
     * 'upcoming' (today or later), 'overdue' (passed, no later record),
     * 'superseded' (passed, later record exists), or null (no next due date).
     *
     * @param  iterable<MaternalVaccination>  $records  the mother's maternal records
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