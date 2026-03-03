<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrekStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'regNumber' => 'required|unique:treks|max:20',
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'municipality_id' => 'required|exists:municipalities,id',
            'interesting_places' => 'required|array',
            'difficulty' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'regNumber.required' => 'Registration number is required.',
            'regNumber.unique' => 'A trek with this registration number already exists.',
            'name.required' => 'Trek name is required.',
            'municipality_id.required' => 'A municipality must be selected.',
            'municipality_id.exists' => 'The selected municipality is invalid.',
            'interesting_places.required' => 'At least one interesting place must be selected.',
        ];
    }
}
