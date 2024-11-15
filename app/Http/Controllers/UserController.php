<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = User::with('roles')->get();
        return response()->json(["datos" => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showAuthenticatedUser ()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Cargar roles si es necesario
        $user->load('roles');

        // Devolver la respuesta
        return response()->json(["datos" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Validar la solicitud
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed', // Si se incluye un nuevo password
            // Agrega otras validaciones según sea necesario
        ]);

        // Actualizar los datos del usuario
        if ($request->has('nombre')) {
            $user->nombre = $request->input('nombre');
        }
        if ($request->has('apellido')) {
            $user->apellido = $request->input('apellido');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        // Actualizar la contraseña solo si se proporciona
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Guardar los cambios
        $user->save();

        // Devolver la respuesta
        return response()->json(["mensaje" => "Usuario actualizado con éxito", "datos" => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function activeUsers()
    {
        // Obtener todos los usuarios que están activos
        $activeUsers = User::with('roles')->where('is_active', true)->get();

        // Devolver la respuesta
        return response()->json(["datos" => $activeUsers]);
    }
}
