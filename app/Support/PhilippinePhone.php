<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Philippine mobile numbers: normalisation and account-wide uniqueness.
 *
 * Canonical form: 11 digits starting with 09 (e.g. 09171234567), the format
 * CareCradle already stores and uses for SMS and SMS password recovery.
 * Equivalent inputs: +63 917 123 4567, 63-917-123-4567, 917 123 4567,
 * (0917) 123-4567. Spaces, dashes, dots and brackets are ignored.
 *
 * Authoritative numbers checked for uniqueness:
 * - mothers.contact_number (a Mother's registered mobile number);
 * - users.contact_number of Administrator and Midwife accounts.
 * (users.contact_number of Mother accounts is a copy of the Mother record's
 * number written at registration, so it is not checked separately.)
 */
final class PhilippinePhone
{
    /** Canonical 09XXXXXXXXX form, or null when the text is not a PH mobile number. */
    public static function normalize(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '' || preg_match('/[^\d\s\-.()+]/', $value)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value);

        if (str_starts_with($value, '+') && ! str_starts_with($digits, '63')) {
            return null;
        }

        if (preg_match('/^639\d{9}$/', $digits)) {
            return '0' . substr($digits, 2);
        }

        if (preg_match('/^09\d{9}$/', $digits)) {
            return $digits;
        }

        if (preg_match('/^9\d{9}$/', $digits)) {
            return '0' . $digits;
        }

        return null;
    }

    /** Stored spellings that mean the same canonical number. */
    public static function variants(string $canonical): array
    {
        $national = substr($canonical, 1); // 9XXXXXXXXX

        return [$canonical, '+63' . $national, '63' . $national, $national];
    }

    /**
     * Which account (if any) other than $ignoreUserId already uses this number.
     * Returns 'mother', 'staff', or null. Stored values are compared with
     * spaces, dashes, dots and brackets removed.
     */
    public static function takenBy(string $canonical, ?int $ignoreUserId = null): ?string
    {
        $variants = self::variants($canonical);
        $stripped = fn (string $column) => "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE({$column}, ' ', ''), '-', ''), '.', ''), '(', ''), ')', '')";
        $placeholders = implode(',', array_fill(0, count($variants), '?'));

        $mother = DB::table('mothers')
            ->whereRaw($stripped('contact_number') . " IN ({$placeholders})", $variants)
            ->when($ignoreUserId, fn ($q) => $q->where(fn ($w) => $w->whereNull('user_id')->orWhere('user_id', '!=', $ignoreUserId)))
            ->exists();

        if ($mother) {
            return 'mother';
        }

        $staff = DB::table('users')
            ->whereIn('role', ['Administrator', 'Midwife'])
            ->whereRaw($stripped('contact_number') . " IN ({$placeholders})", $variants)
            ->when($ignoreUserId, fn ($q) => $q->where('id', '!=', $ignoreUserId))
            ->exists();

        return $staff ? 'staff' : null;
    }

    /** Masked form for logs and screens, e.g. ****736. Never returns the full number. */
    public static function mask(?string $value): string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);

        return $digits === '' ? '(none)' : '****' . substr($digits, -3);
    }

    /** True when both values are the same PH mobile number in any accepted spelling. */
    public static function same(?string $a, ?string $b): bool
    {
        $na = self::normalize($a);

        return $na !== null && $na === self::normalize($b);
    }

    /**
     * SQL expression: the last 10 digits of a stored number with separators and
     * the leading + removed, so 09171234567 and +639171234567 compare equal.
     */
    public static function sqlTail(string $column): string
    {
        return "RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE({$column}, ' ', ''), '-', ''), '.', ''), '(', ''), ')', ''), '+', ''), 10)";
    }
}
