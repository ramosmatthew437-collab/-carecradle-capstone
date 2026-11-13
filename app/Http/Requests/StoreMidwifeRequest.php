<?php
namespace App\Http\Requests;



use App\Http\Requests\Concerns\NormalizesAccountContact;
use App\Rules\UniqueEmailInsensitive;
use App\Rules\UniquePhilippinePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreMidwifeRequest extends FormRequest
{
    use NormalizesAccountContact;

    /** Email: trimmed + lower-cased. Mobile number: saved as 09XXXXXXXXX. */
    protected function prepareForValidation(): void
    {
        $this->normalizeAccountContact();
    }

    /**
     * Determine if the user is authorized.
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
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
            ],

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            // Optional; a Philippine mobile number not used by another account.
            'contact_number' => [
                'nullable',
                'string',
                'max:20',
                new UniquePhilippinePhone(),
            ],

            // Optional; unique across accounts regardless of letter case.
            'email' => [
                'nullable',
                'email',
                'max:255',
                new UniqueEmailInsensitive(),
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }
}
