<?php

namespace App\Rules;

use App\Support\PhilippinePhone;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * The value must be a Philippine mobile number (any accepted spelling) that
 * no other CareCradle account already uses (see PhilippinePhone::takenBy).
 *
 * - $ignoreUserId: the account being edited (its own number is not a conflict).
 * - $currentValue: the number stored on the record being edited; submitting the
 *   same number again is always allowed, so older records that already share
 *   a number can still be saved for other changes.
 */
class UniquePhilippinePhone implements ValidationRule
{
    public function __construct(
        private readonly ?int $ignoreUserId = null,
        private readonly ?string $currentValue = null,
        private readonly bool $requireFormat = true,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return; // required / nullable are handled by other rules
        }

        $canonical = PhilippinePhone::normalize($value);
        $current = PhilippinePhone::normalize($this->currentValue);

        if ($canonical === null) {
            if ($this->requireFormat && trim($value) !== trim((string) $this->currentValue)) {
                $fail('Enter a valid Philippine mobile number, for example 09171234567 or +63 917 123 4567.');
            }

            return;
        }

        if ($current !== null && $canonical === $current) {
            return; // keeping the number already on this record
        }

        if (PhilippinePhone::takenBy($canonical, $this->ignoreUserId) !== null) {
            $fail('This mobile number is already registered to another CareCradle account.');
        }
    }
}
