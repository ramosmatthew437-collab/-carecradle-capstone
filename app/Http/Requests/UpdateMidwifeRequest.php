<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\NormalizesAccountContact;
use App\Models\User;
use App\Rules\UniqueEmailInsensitive;
use App\Rules\UniquePhilippinePhone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMidwifeRequest extends FormRequest
{
    use NormalizesAccountContact;

    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** Email: trimmed + lower-cased. Mobile number: saved as 09XXXXXXXXX. */
    protected function prepareForValidation(): void
    {
        $this->normalizeAccountContact();
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        $midwifeId = $this->route('midwife');
        $midwifeId = $midwifeId instanceof User ? $midwifeId->id : (int) $midwifeId;
        $current = User::find($midwifeId);

        return [

            'username' => 'required|string|max:50|unique:users,username,' . $midwifeId,

            'first_name' => 'required|string|max:100',

            'middle_name' => 'nullable|string|max:100',

            'last_name' => 'required|string|max:100',

            // Optional; unique across accounts. The midwife's current number
            // is always accepted (older records may share a number).
            'contact_number' => [
                'nullable',
                'string',
                'max:20',
                new UniquePhilippinePhone($midwifeId, $current?->contact_number),
            ],

            // Optional; unique across accounts regardless of letter case.
            'email' => [
                'nullable',
                'email',
                'max:255',
                new UniqueEmailInsensitive($midwifeId),
            ],

        ];
    }
}
