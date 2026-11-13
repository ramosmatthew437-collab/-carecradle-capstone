<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ResolvesExpectedDeliveryDate;
use App\Models\Mother;
use App\Rules\UniquePhilippinePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class UpdateMotherRequest extends FormRequest
{
    use ResolvesExpectedDeliveryDate;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'birth_date' => [
                'required',
                'date',
            ],

            // Registered mobile number: not used by another account. This
            // mother's current number is always accepted, so older records
            // that already share a number can still be edited.
            'contact_number' => [
                'required',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
                new UniquePhilippinePhone(
                    $this->currentMother()?->user_id,
                    $this->currentMother()?->contact_number,
                    false,
                ),
            ],

            'address' => [
                'required',
                'string',
            ],

            'barangay' => [
                'required',
                'string',
                'max:255',
            ],

            'blood_type' => [
                'required',
                'string',
                'max:5',
            ],

            'civil_status' => [
                'required',
                'string',
                'max:100',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:255',
            ],
            
            // Father's Information
            'father_first_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'father_middle_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'father_last_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'father_birth_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'father_contact_number' => [
                'nullable',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
            ],

            'father_occupation' => [
                'nullable',
                'string',
                'max:255',
            ],


            'philhealth_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'height' => [
                'required',
                'numeric',
            ],

            'weight' => [
                'required',
                'numeric',
            ],

            'last_menstrual_period' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            // Automatic (kept while the LMP is unchanged, otherwise LMP + 280
            // days) unless adjusted by the midwife; see ResolvesExpectedDeliveryDate.
            'expected_delivery_date' => [
                'nullable',
                'date',
            ],

            // The EDD the form was rendered with (hidden); used only to detect
            // whether the EDD was changed in this form.
            'edd_initial' => [
                'nullable',
                'date',
            ],

            'pregnancy_number' => [
                'required',
                'integer',
                'min:1',
            ],
            // Pregnancy status. Referral is recorded separately (Referrals).
            // 'Referred' is accepted only to keep an older record unchanged
            // (pregnancy status unknown); it cannot be chosen for anyone else.
            'status' => [
                'required',
                'in:' . implode(',', $this->currentMother()?->isLegacyReferred()
                    ? [...Mother::PREGNANCY_STATUSES, Mother::LEGACY_REFERRED]
                    : Mother::PREGNANCY_STATUSES),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'pregnancy_number' => 'pregnancy history (gravida)',
            'status' => 'pregnancy status',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Please choose Pregnant or Delivered. Referrals are recorded separately on the mother\'s profile.',
        ];
    }

    /**
     * Server-side EDD check: a manual adjustment must be a valid date after
     * the LMP (see ResolvesExpectedDeliveryDate).
     */
    public function after(): array
    {
        return [
            fn (Validator $validator) => $this->validateManualExpectedDeliveryDate($validator),
        ];
    }

    /**
     * The EDD without a manual adjustment:
     * - LMP unchanged: the existing EDD is kept exactly as recorded
     *   (existing values are never silently overwritten);
     * - LMP changed: recalculated as LMP + 280 days.
     */
    protected function automaticExpectedDeliveryDate(): ?string
    {
        $mother = $this->currentMother();

        if ($mother && ! $this->lmpChanged()) {
            return $mother->expected_delivery_date
                ? Carbon::parse($mother->expected_delivery_date)->toDateString()
                : Mother::calculateExpectedDeliveryDate($this->input('last_menstrual_period'));
        }

        return Mother::calculateExpectedDeliveryDate($this->input('last_menstrual_period'));
    }

    private function lmpChanged(): bool
    {
        $mother = $this->currentMother();
        $submitted = $this->input('last_menstrual_period');

        if (! $mother || blank($submitted) || blank($mother->last_menstrual_period)) {
            return true;
        }

        return Carbon::parse($submitted)->toDateString()
            !== Carbon::parse($mother->last_menstrual_period)->toDateString();
    }

    private function currentMother(): ?Mother
    {
        $routeMother = $this->route('mother');

        return $routeMother instanceof Mother ? $routeMother : Mother::find($routeMother);
    }
}