<?php

namespace App\Http\Controllers;

use App\Models\IndicadoresFinancieros;
use Illuminate\Http\Request;

class IndicadoresFinancierosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = IndicadoresFinancieros::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "valor" => "required",
        ]);

        $item = new IndicadoresFinancieros();
        $item->nombre = $request->nombre;
        $item->valor = $request->valor;
        $item->save();
        return response()->json(["mensaje" => "Indicador financiero creado", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = IndicadoresFinancieros::find($id);
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
            "nombre" => "nullable",
            "valor" => "nullable",
        ]);

        $item = IndicadoresFinancieros::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->nombre = $request->nombre;
        $item->valor = $request->valor;
        $item->save();
        return response()->json(["mensaje" => "Indicador financiero actualizado", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = IndicadoresFinancieros::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = IndicadoresFinancieros::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
