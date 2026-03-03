<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name' => 'required|min:5|max:255',
           'lastname' => 'required|min:5|max:255',
           'dni' => 'required|unique:users|min:5|max:255',
           'email' => 'required|unique:users|min:5|max:255', 
           'phone' => 'required|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'lastname.required' => 'Last name is required.',
            'dni.required' => 'DNI is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'dni.unique' => 'This DNI is already registered.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
