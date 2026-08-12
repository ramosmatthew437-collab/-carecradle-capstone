<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMidwifeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        $midwifeId = $this->route('midwife');

        return [

            'username' => 'required|string|max:50|unique:users,username,' . $midwifeId,

            'first_name' => 'required|string|max:100',

            'middle_name' => 'nullable|string|max:100',

            'last_name' => 'required|string|max:100',

            'contact_number' => 'nullable|string|max:20',

            'email' => 'nullable|email|unique:users,email,' . $midwifeId,

        ];
    }
}