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
    public function show(string $id)
    {
        $item = User::with('roles')->find($id);
        if (!$item) {
            return response()->json(["mensaje" => "El usuario no existe"], 404);
        }
        return response()->json(["datos" => $item]);
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
        $user->nombre = $request->input('nombre', $user->nombre);
        $user->apellido = $request->input('apellido', $user->apellido);
        $user->email = $request->input('email', $user->email);

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
