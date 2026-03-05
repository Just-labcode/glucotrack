<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloodSugarReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level'        => ['required', 'numeric', 'min:20', 'max:600'],
            'meal_context' => ['required', 'in:fasting,before_meal,after_meal,bedtime,random'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'level.required' => 'Blood sugar level is required.',
            'level.numeric'  => 'Blood sugar level must be a number.',
            'level.min'      => 'Blood sugar level must be at least 20 mg/dL.',
            'level.max'      => 'Blood sugar level cannot exceed 600 mg/dL.',
            'meal_context.required' => 'Please select a meal context.',
            'meal_context.in'       => 'Invalid meal context selected.',
        ];
    }
}