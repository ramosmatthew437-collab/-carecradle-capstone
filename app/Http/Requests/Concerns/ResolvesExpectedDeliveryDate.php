<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

/**
 * Expected delivery date (EDD) handling shared by the mother registration and
 * edit requests.
 *
 * The EDD is "automatic" (LMP + 280 days, or the recorded EDD while the LMP is
 * unchanged on edit; see automaticExpectedDeliveryDate()) unless the midwife
 * adjusted it. The form carries the EDD it was rendered with in the hidden
 * `edd_initial` field, so the server can tell the two apart without relying
 * on JavaScript:
 *
 * - EDD blank, unchanged from edd_initial, or equal to the automatic value
 *   -> automatic (calculated on the server);
 * - otherwise -> a manual adjustment, kept as entered after validation.
 *
 * A tampered edd_initial can only make a submitted EDD count as manual, and a
 * manual EDD is still validated.
 */
trait ResolvesExpectedDeliveryDate
{
    /** A manual EDD may be at most this many days after the LMP (typo guard). */
    public const MANUAL_EDD_MAX_DAYS_AFTER_LMP = 365;

    /** The EDD the server would set without a manual adjustment. */
    abstract protected function automaticExpectedDeliveryDate(): ?string;

    /** The EDD to store. */
    public function expectedDeliveryDate(): ?string
    {
        return $this->eddIsManual()
            ? $this->submittedDate('expected_delivery_date')
            : $this->automaticExpectedDeliveryDate();
    }

    /** True when the submitted EDD is an intentional manual adjustment. */
    public function eddIsManual(): bool
    {
        $submitted = $this->submittedDate('expected_delivery_date');

        if ($submitted === null || $submitted === $this->submittedDate('edd_initial')) {
            return false;
        }

        return $submitted !== $this->automaticExpectedDeliveryDate();
    }

    /** Validates a manual EDD against the LMP (called from after()). */
    protected function validateManualExpectedDeliveryDate(Validator $validator): void
    {
        if ($validator->errors()->hasAny(['last_menstrual_period', 'expected_delivery_date', 'edd_initial'])
            || ! $this->eddIsManual()) {
            return;
        }

        $lmp = Carbon::parse($this->input('last_menstrual_period'))->startOfDay();
        $edd = Carbon::parse($this->submittedDate('expected_delivery_date'))->startOfDay();

        if ($edd->lte($lmp)) {
            $validator->errors()->add('expected_delivery_date', 'The expected delivery date must be after the last menstrual period.');
        } elseif ($edd->gt($lmp->copy()->addDays(self::MANUAL_EDD_MAX_DAYS_AFTER_LMP))) {
            $validator->errors()->add('expected_delivery_date', 'The expected delivery date must be within one year of the last menstrual period.');
        }
    }

    /** A submitted date as Y-m-d, or null when blank or not a date. */
    private function submittedDate(string $key): ?string
    {
        $value = $this->input($key);

        if (blank($value)) {
            return null;
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }
}
