<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrekUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $trekId = $this->route('id');
        // en caso de que se use route model binding directamente
        if (is_object($trekId) && isset($trekId->id)) {
            $trekId = $trekId->id;
        }

        return [
            'regNumber' => 'required|max:20|unique:treks,regNumber,' . $trekId,
            'name' => 'required|max:100',
            'description' => 'nullable|string',
            'municipality_id' => 'required|exists:municipalities,id',
            'places' => 'required|array',
            'difficulty' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'regNumber.required' => 'Registration number is required.',
            'regNumber.unique' => 'This registration number is already in use.',
            'name.required' => 'Trek name is required.',
            'municipality_id.required' => 'A municipality must be selected.',
            'places.required' => 'At least one interesting place must be selected.',
        ];
    }
}
