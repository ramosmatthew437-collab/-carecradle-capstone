<?php

namespace App\Http\Requests;


use App\Rules\UniqueEmailInsensitive;
use App\Rules\UniquePhilippinePhone;
use App\Support\PhilippinePhone;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Account profile update (all roles; the signed-in user's own account only).
 *
 * - Email: trimmed and lower-cased, unique across accounts regardless of
 *   letter case (own address ignored). Required for Administrator and
 *   Midwife accounts as before; optional for Mother accounts, which are
 *   registered without an email.
 * - Administrator / Midwife: first, middle and last name (the display name
 *   is built from them, as in Midwife Management) and an optional mobile
 *   number (users.contact_number).
 * - Mother: account display name and her registered mobile number
 *   (mothers.contact_number, the number used for SMS).
 * - Mobile numbers: any accepted Philippine spelling, saved as 09XXXXXXXXX,
 *   unique across accounts; keeping the current number is always allowed.
 */
class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
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

        $this->merge($merge);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $isMother = $user->isMother() && $user->mother;

        $rules = [
            'email' => [
                $isMother ? 'nullable' : 'required',
                'string',
                'email',
                'max:255',
                new UniqueEmailInsensitive($user->id),
            ],
        ];

        if ($isMother) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['contact_number'] = [
                'required',
                'string',
                'max:20',
                new UniquePhilippinePhone($user->id, $user->mother->contact_number),
            ];
        } else {
            $rules['first_name'] = ['required', 'string', 'max:100'];
            $rules['middle_name'] = ['nullable', 'string', 'max:100'];
            $rules['last_name'] = ['required', 'string', 'max:100'];
            $rules['contact_number'] = [
                'nullable',
                'string',
                'max:20',
                new UniquePhilippinePhone($user->id, $user->contact_number),
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Enter a valid email address, for example name@example.com.',
            'contact_number.required' => 'Enter your mobile number. It is used for appointment reminders and SMS password recovery.',
        ];
    }

    public function attributes(): array
    {
        return [
            'contact_number' => 'mobile number',
            'first_name' => 'first name',
            'middle_name' => 'middle name',
            'last_name' => 'last name',
        ];
    }
}
