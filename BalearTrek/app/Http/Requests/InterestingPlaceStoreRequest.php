<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterestingPlaceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'gps' => 'required|unique:interesting_places',
            'place_type_id' => 'required|exists:place_types,id',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Place name is required.',
            'gps.required' => 'GPS location is required.',
            'gps.unique' => 'A place with these coordinates already exists.',
            'place_type_id.required' => 'A place type must be selected.',
            'place_type_id.exists' => 'The selected place type is invalid.',
        ];
    }
}
