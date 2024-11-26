<?php

namespace App\Http\Controllers;

use App\Models\ValoresFundamentales;
use Illuminate\Http\Request;

class ValoresFundamentalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ValoresFundamentales::orderBy('id', 'desc')->paginate(5);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titulo" => "required",
            "descripcion" => "nullable",
        ]);

        $item = new ValoresFundamentales();
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Registro creado", "datos" => $item], 201);
    }

    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = ValoresFundamentales::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = ValoresFundamentales::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Servicio no encontrado"], 404);
        }
        $request->validate([
            "titulo" => "required",
            "descripcion" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        $item->save();

        return response()->json(["mensaje" => "Servicio actualizado con éxito", "datos" => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ValoresFundamentales::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = ValoresFundamentales::where('estado', true)->orderBy('id', 'desc')->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
