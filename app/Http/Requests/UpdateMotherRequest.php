<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMotherRequest extends FormRequest
{
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

            'contact_number' => [
                'required',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
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
            ],

            'expected_delivery_date' => [
                'required',
                'date',
                'after:last_menstrual_period',
            ],

            'pregnancy_number' => [
                'required',
                'integer',
                'min:1',
            ],
            'status' => [
    'required',
    'in:Pregnant,Delivered,Referred',
],
            

            

        ];
    }
}