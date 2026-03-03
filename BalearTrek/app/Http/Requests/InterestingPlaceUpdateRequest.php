<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterestingPlaceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $placeId = optional($this->route('interestingPlace'))->id ?? $this->route('interestingPlace');
        if (is_object($placeId) && isset($placeId->id)) {
            $placeId = $placeId->id;
        }

        return [
            'name' => 'required|max:100',
            'gps' => 'required|unique:interesting_places,gps,' . $placeId,
            'place_type_id' => 'required|exists:place_types,id',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Place name is required.',
            'gps.required' => 'GPS location is required.',
            'gps.unique' => 'These coordinates are already used by another place.',
            'place_type_id.required' => 'A place type must be selected.',
        ];
    }
}
