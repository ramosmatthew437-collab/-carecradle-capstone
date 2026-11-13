<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

/**
 * The email address must not belong to another account, comparing without
 * letter case and surrounding spaces. $ignoreUserId is the account being
 * edited. (The users.email unique index is case-insensitive too; this rule
 * reports a field error before the database would refuse the value.)
 */
class UniqueEmailInsensitive implements ValidationRule
{
    public function __construct(private readonly ?int $ignoreUserId = null)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return;
        }

        $taken = DB::table('users')
            ->whereRaw('LOWER(TRIM(email)) = ?', [mb_strtolower(trim($value))])
            ->when($this->ignoreUserId, fn ($q) => $q->where('id', '!=', $this->ignoreUserId))
            ->exists();

        if ($taken) {
            $fail('This email address is already used by another CareCradle account.');
        }
    }
}
