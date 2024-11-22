<?php

namespace App\Http\Controllers;

use App\Models\OpcionesDeSerSocios;
use App\Models\RequirimientosDeSerSocios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequerimientosSerSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = OpcionesDeSerSocios::orderBy('id', 'desc')->with('requerimientos')->get();
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titulo" => "required",
            'descripcion' => "required",
            "requerimientos" => "nullable|array", // Asegúrate de que sea un array
        ]);
        try {
            DB::beginTransaction();
            $item = new OpcionesDeSerSocios();
            $item->titulo = $request->titulo;
            $item->descripcion = $request->descripcion;
            $item->save();
            // Guardar requerimientos
            $requerimientos = $request->requerimientos ?? []; // Asegúrate de que sea un array
            foreach ($requerimientos as $requerimiento) {
                if (!empty($requerimientos)) { // Verificar que la recomendación no esté vacía
                    RequirimientosDeSerSocios::create([
                        'ser_socio_id' => $item->id,
                        'requerimientos' => $requerimiento, // Asegúrate de que este campo sea correcto
                    ]);
                }
            }

            DB::commit();
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "No se pudo realizar el registro: " . $th->getMessage()], 406);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = OpcionesDeSerSocios::with('requerimientos')->find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        return response()->json(["mensaje" => "Registro cargado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            "titulo" => "required|string|max:255", // Cambiado a 'required'
            'descripcion' => "required|string", // Asegúrate de que sea una cadena
            "requerimientos" => "nullable|array",
        ]);

        // Buscar el registro
        $item = OpcionesDeSerSocios::findOrFail($id);

        // Actualizar los campos
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;

        // Manejo de errores al guardar
        try {
            $item->save();
        } catch (\Exception $e) {
            return response()->json(["mensaje" => "Error al actualizar el registro: " . $e->getMessage()], 500);
        }

        // Actualizar requerimientos
        $requerimientos = $request->requerimientos ?? []; // Asegúrate de que sea un array
        RequirimientosDeSerSocios::where('ser_socio_id', $item->id)->delete(); // Eliminar los requerimientos actuales

        foreach ($requerimientos as $requerimiento) {
            if (!empty($requerimiento)) { // Verificar que el requerimiento no esté vacío
                RequirimientosDeSerSocios::create([
                    'ser_socio_id' => $item->id,
                    'requerimientos' => $requerimiento, // Asegúrate de que este campo sea correcto
                ]);
            }
        }

        return response()->json(["mensaje" => "Registro actualizado", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Realizar un soft delete (cambiar el estado a is_deleted)
        $item = OpcionesDeSerSocios::find($id);

        if (!$item) {
            return response()->json(["mensaje" => "Red social no encontrada"], 404);
        }

        $item->estado = !$item->estado; // Cambia el estado del campo estado

        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modificar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        // Obtener todas las redes sociales no eliminadas
        $datos = OpcionesDeSerSocios::with('requerimientos')->where('estado', true)->get();
        return response()->json(
            [
                "mensaje" => "Datos cargados",
                "datos" => $datos
            ],
            200
        );
    }
}
