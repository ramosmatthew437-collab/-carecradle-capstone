<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use App\Models\Vaccination;


class Infant extends Model
{protected $fillable = [
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
    'photo_path',
];

    /**
     * Authorized registration exceptions (used when the mother has no
     * qualifying prenatal checkup in CareCradle). Keys are submitted by the
     * form; labels are what is stored and shown.
     */
    public const EXCEPTION_REASONS = [
        'other_facility' => 'Prenatal care received at another healthcare facility',
        'walk_in_delivery' => 'Walk-in or emergency delivery',
    ];

    /**
     * Structured notation for a registration exception, stored at the start
     * of the existing remarks column (no schema change). Everything between
     * the markers is the exception; anything after is ordinary clinical
     * remarks. Example:
     *
     *   [REGISTRATION EXCEPTION]
     *   Reason: Walk-in or emergency delivery
     *   Authorized by: Maria Santos (maria.santos)
     *   Recorded: 2026-11-12 20:03
     *   Notes: Delivered on arrival; no prenatal record available.
     *   [/REGISTRATION EXCEPTION]
     */
    public const EXCEPTION_START = '[REGISTRATION EXCEPTION]';
    public const EXCEPTION_END = '[/REGISTRATION EXCEPTION]';

    private const EXCEPTION_PATTERN = '/\A\s*\[REGISTRATION EXCEPTION\]\R(.*?)\R\[\/REGISTRATION EXCEPTION\]\R?/s';

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

    /**
     * Builds the stored exception block. Free text is cleaned of the marker
     * strings so it can never end or forge a block.
     */
    public static function buildExceptionBlock(string $reasonKey, ?string $facility, string $notes, User $authorizedBy, ?Carbon $at = null): string
    {
        $lines = [self::EXCEPTION_START, 'Reason: ' . self::EXCEPTION_REASONS[$reasonKey]];

        if ($reasonKey === 'other_facility' && filled($facility)) {
            $lines[] = 'Facility: ' . self::singleLine(self::withoutMarkers($facility));
        }

        $lines[] = 'Authorized by: ' . self::singleLine($authorizedBy->name ?: 'Midwife')
            . ($authorizedBy->username ? " ({$authorizedBy->username})" : '');
        $lines[] = 'Recorded: ' . ($at ?? now())->format('Y-m-d H:i');
        $lines[] = 'Notes: ' . trim(self::withoutMarkers($notes));
        $lines[] = self::EXCEPTION_END;

        return implode("\n", $lines);
    }

    /** Stored remarks: exception block (if any) followed by clinical remarks. */
    public static function composeRemarks(?string $exceptionBlock, ?string $clinicalRemarks): ?string
    {
        $clinical = trim((string) self::withoutMarkers($clinicalRemarks));
        $parts = array_filter([trim((string) $exceptionBlock), $clinical], 'filled');

        return $parts ? implode("\n\n", $parts) : null;
    }

    /** The raw exception block stored at the start of the remarks, or null. */
    public function exceptionBlock(): ?string
    {
        return preg_match(self::EXCEPTION_PATTERN, (string) $this->remarks, $match)
            ? rtrim($match[0])
            : null;
    }

    /**
     * The registration exception as fields (reason, facility, authorized_by,
     * recorded, notes), or null when the infant was registered normally.
     */
    public function registrationException(): ?array
    {
        if (! preg_match(self::EXCEPTION_PATTERN, (string) $this->remarks, $match)) {
            return null;
        }

        $fields = ['reason' => null, 'facility' => null, 'authorized_by' => null, 'recorded' => null, 'notes' => null];
        $keys = ['Reason' => 'reason', 'Facility' => 'facility', 'Authorized by' => 'authorized_by', 'Recorded' => 'recorded'];
        $lines = preg_split('/\R/', $match[1]);

        foreach ($lines as $i => $line) {
            if (str_starts_with($line, 'Notes: ')) {
                // Notes are last and may span several lines.
                $fields['notes'] = trim(implode("\n", array_merge([substr($line, 7)], array_slice($lines, $i + 1))));
                break;
            }

            foreach ($keys as $label => $key) {
                if (str_starts_with($line, $label . ': ')) {
                    $fields[$key] = trim(substr($line, strlen($label) + 2));
                }
            }
        }

        return $fields;
    }

    /** Ordinary clinical remarks, without the exception block. */
    public function clinicalRemarks(): ?string
    {
        $clinical = trim((string) preg_replace(self::EXCEPTION_PATTERN, '', (string) $this->remarks, 1));

        return $clinical === '' ? null : $clinical;
    }

    private static function withoutMarkers(?string $text): string
    {
        return (string) preg_replace('/\[\s*\/?\s*REGISTRATION\s+EXCEPTION\s*\]/i', '', (string) $text);
    }

    private static function singleLine(string $text): string
    {
        return trim((string) preg_replace('/\s+/', ' ', $text));
    }
}
