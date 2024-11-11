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
    
        // Intentar autenticar al usuario
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Obtener el usuario autenticado
        $usuario = Auth::user()->load('roles');
    
        // Cambiar el estado is_active a 1
        $usuario->is_active = 1;
        $usuario->save();
    
        // Crear el token de acceso
        $token = $usuario->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Sesión iniciada',
            'access_token' => $token,
            "user" => $usuario,
            'token_type' => 'Bearer'
        ], 200);
    }
    public function logout() {
        $usuario = Auth::user();
    
        // Cambiar el estado is_active a 0
        $usuario->is_active = 0;
        $usuario->save();
    
        // Eliminar todos los tokens del usuario
        $usuario->tokens()->delete();
    
        return response()->json(["mensaje" => "Sesión finalizada"], 200);
    }
}
