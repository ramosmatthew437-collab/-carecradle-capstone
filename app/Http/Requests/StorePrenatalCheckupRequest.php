<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrenatalCheckupRequest extends FormRequest
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

            'visit_date' => [
                'required',
                'date',
            ],

            'gestational_age_weeks' => [
                'required',
                'integer',
                'min:1',
                'max:42',
            ],

            'weight' => [
                'required',
                'numeric',
                'min:1',
            ],

            'systolic_bp' => [
                'required',
                'integer',
                'min:50',
                'max:250',
            ],

            'diastolic_bp' => [
                'required',
                'integer',
                'min:30',
                'max:200',
            ],

            'fundal_height' => [
                'nullable',
                'numeric',
            ],

            'fetal_heart_rate' => [
                'nullable',
                'integer',
            ],

            'fetal_movement' => [
                'nullable',
                  'in:Normal,Reduced,Not Yet Felt',
            ],

            'urine_protein' => [
                'nullable',
                 'in:Negative,Trace,+1,+2,+3',
            ],

            'urine_glucose' => [
                'nullable',
                 'in:Negative,Trace,+1,+2,+3',
            ],

            'maternal_condition' => [
                'nullable',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'next_visit_date' => [
                'nullable',
                'date',
                'after_or_equal:visit_date',
            ],

        ];
    }
}