<?php

namespace App\Http\Requests;


use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ];

        // Only validate contact_number when the Mother form submits it.
        if ($user->isMother() && $user->mother) {
            $rules['contact_number'] = [
                'required',
                'string',
                'max:20',
                'regex:/^(09\d{9}|\+639\d{9})$/',
            ];
        }

        return $rules;
    }
}
