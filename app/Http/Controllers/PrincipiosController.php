<?php

namespace App\Http\Controllers;

use App\Models\principios;
use Illuminate\Http\Request;

class PrincipiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = principios::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nro_de_principio" => "required",
            "titulo" => "required",
            "descripcion" => "nullable",
        ]);

        $item = new principios();
        $item->nro_de_principio = $request->nro_de_principio;
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        $item->save();

        return response()->json(["mensaje" => "Registro creado", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = principios::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nro_de_principio" => "required",
            "titulo" => "required",
            "descripcion" => "nullable",
        ]);
        $item = principios::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->nro_de_principio = $request->nro_de_principio;
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = principios::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = principios::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
