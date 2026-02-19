<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class ApiRegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'unique:users'], // Requisito Punto 9
            'phone' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Obtener el rol por defecto (visitante)
        $visitantRole = Role::where('name', 'visitant')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $visitantRole->id,
        ]);

        // Generamos el token de Sanctum para React
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }
}