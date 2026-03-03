<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Municipality name is required.',
            'island_id.required' => 'An island must be selected.',
            'island_id.exists' => 'The selected island does not exist.',
            'zone_id.required' => 'A zone must be selected.',
            'zone_id.exists' => 'The selected zone does not exist.',
        ];
    }
}
