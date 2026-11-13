<?php

namespace App\Http\Requests\Concerns;

use App\Support\PhilippinePhone;

/**
 * Normalises account contact fields before validation:
 * - email: trimmed and lower-cased (empty becomes null);
 * - contact_number: trimmed; a Philippine mobile number in any accepted
 *   spelling becomes 09XXXXXXXXX. Other text is left as typed so the
 *   validation rules can report it (or keep an unchanged older value).
 */
trait NormalizesAccountContact
{
    protected function normalizeAccountContact(): void
    {
        $merge = [];

        if (is_string($this->input('email'))) {
            $email = mb_strtolower(trim($this->input('email')));
            $merge['email'] = $email === '' ? null : $email;
        }

        if (is_string($this->input('contact_number'))) {
            $raw = trim($this->input('contact_number'));
            $merge['contact_number'] = $raw === '' ? null : (PhilippinePhone::normalize($raw) ?? $raw);
        }

        if ($merge) {
            $this->merge($merge);
        }
    }
}
