<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // a nivel de administración, cualquiera autenticado puede crear usuarios
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:users,dni',
            'email' => 'required|string|email|max:100|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'lastname.required' => 'Last name is required.',
            'dni.required' => 'DNI is required.',
            'dni.unique' => 'This DNI is already registered.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'A user with this email already exists.',
            'phone.max' => 'Phone may not be greater than 20 characters.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'role_id.required' => 'A role must be assigned to the user.',
            'role_id.exists' => 'Selected role is invalid.',
        ];
    }
}
