<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Solo cargar el usuario sin datos adicionales
        $usuario = Auth::user();
        $token = $usuario->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Sesión iniciada',
            'access_token' => $token,
            "user" => $usuario, // Aquí se devuelve solo el usuario sin datos adicionales
            'token_type' => 'Bearer'
        ], 200);
    }
    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json(["mensaje" => "Sesion finalizada"], 200);
    }
}
