<?php

namespace App\Http\Controllers;

use App\Models\WebRedesSocialesCoop;
use Illuminate\Http\Request;

class RedesSocialesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las redes sociales con la información de la empresa relacionada
        $redesSociales = WebRedesSocialesCoop::orderBy('id', 'desc')->paginate(10);

        return response()->json(
            [
                "mensaje" => "Datos cargados",
                "datos" => $redesSociales
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|max:50',
            'logo' => [
                'required',
                'regex:/^(fa|fab|fa-brands|fa-solid) [a-z-]+(\s+(fa|fab|fa-brands|fa-solid) [a-z-]+)*$/'
            ],

            'url' => 'required|url|max:255',  // Aumentar el límite de la URL
        ]);

        // Crear una nueva red social
        $redSocial = new WebRedesSocialesCoop();
        $redSocial->nombre = $request->nombre;
        $redSocial->logo = $request->logo;
        $redSocial->url = $request->url;

        if ($redSocial->save()) {
            return response()->json([
                'mensaje' => 'Red social creada correctamente',
                'datos' => $redSocial
            ], 201);
        } else {
            return response()->json([
                'mensaje' => 'Error al crear la red social'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener una red social específica
        $redSocial = WebRedesSocialesCoop::find($id);

        // Verificar si se encontró el registro
        if ($redSocial) {
            return response()->json([
                "mensaje" => "Datos cargados",
                "datos" => $redSocial
            ], 200);
        } else {
            return response()->json([
                "mensaje" => "Registro no encontrado"
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|unique:web_redes_sociales_coops,nombre,' . $id,
            'logo' => [
                'required',
            ],
            "url" => "nullable|url|max:250",
        ]);
        // Asegúrate de que estás accediendo a la tabla correcta
        $redSocial = WebRedesSocialesCoop::where('id', $id)->first();
        // Actualizar los campos de la red social
        $redSocial->nombre = $request->nombre;
        $redSocial->logo = $request->logo;
        $redSocial->url = $request->url;

        // Guardar los cambios
        if ($redSocial->save()) {
            return response()->json([
                "mensaje" => "Red social actualizada correctamente",
                "datos" => $redSocial
            ], 200);
        } else {
            return response()->json([
                "mensaje" => "Error al actualizar la red social"
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Realizar un soft delete (cambiar el estado a is_deleted)
        $redSocial = WebRedesSocialesCoop::find($id);

        if (!$redSocial) {
            return response()->json(["mensaje" => "Red social no encontrada"], 404);
        }

        $redSocial->estado = !$redSocial->estado; // Cambia el estado del campo estado

        if ($redSocial->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $redSocial], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modificar el estado"], 422);
        }
    }
    public function redesSocialesActivo()
    {
        // Obtener todas las redes sociales no eliminadas
        $redesSociales = WebRedesSocialesCoop::where('estado', true)->get();
        return response()->json(
            [
                "mensaje" => "Datos cargados",
                "datos" => $redesSociales
            ],
            200
        );
    }
}
