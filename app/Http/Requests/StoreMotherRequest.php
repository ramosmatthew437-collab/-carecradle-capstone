<?php
namespace App\Http\Requests;

use App\Http\Requests\Concerns\ResolvesExpectedDeliveryDate;
use App\Models\Mother;
use App\Rules\UniquePhilippinePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class StoreMotherRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Password::defaults(),
            ],

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

            // Registered mobile number: 09XXXXXXXXX, not used by another
            // account (equivalent spellings such as +63 9XX count as the same).
            'contact_number' => [
                'required',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
                new UniquePhilippinePhone(),
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

            // Father's Information (same rules as UpdateMotherRequest)
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

            // LMP + 280 days unless adjusted by the midwife; see
            // ResolvesExpectedDeliveryDate.
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
        ];
    }

    public function attributes(): array
    {
        return [
            'pregnancy_number' => 'pregnancy history (gravida)',
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
     * The EDD without a manual adjustment: LMP + 280 days.
     */
    protected function automaticExpectedDeliveryDate(): ?string
    {
        return Mother::calculateExpectedDeliveryDate($this->input('last_menstrual_period'));
    }
}