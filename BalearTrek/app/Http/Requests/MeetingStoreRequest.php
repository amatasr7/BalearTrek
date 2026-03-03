<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'day' => 'required|date',
            'time' => 'required',
            'appDateIni' => 'required|date',
            'appDateEnd' => 'required|date|after_or_equal:appDateIni',
            'trek_id' => 'required|exists:treks,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'day.required' => 'Meeting date is required.',
            'time.required' => 'Meeting time is required.',
            'appDateIni.required' => 'Application start date is required.',
            'appDateEnd.required' => 'Application end date is required.',
            'appDateEnd.after_or_equal' => 'Application end date must be the same as or later than the start date.',
            'trek_id.required' => 'A trek must be selected.',
            'trek_id.exists' => 'The selected trek does not exist.',
            'user_id.required' => 'A guide must be selected.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
