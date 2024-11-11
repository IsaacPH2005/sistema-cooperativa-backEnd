<?php

namespace App\Http\Controllers;

use App\Models\TablaDpfs;
use Illuminate\Http\Request;

class TabladpfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = TablaDpfs::paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plazo' => 'required|integer',
            'interes_bs' => 'required|numeric',
            'interes_usd' => 'required|numeric',
        ]);
        $item = new TablaDpfs();
        $item->plazo = $request->plazo;
        $item->interes_bs = $request->interes_bs;
        $item->interes_usd = $request->interes_usd;
        $item->save();
        return response()->json(["mensaje" => "Datos creados", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = TablaDpfs::find($id);
        // Verificar si el registro existe
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
            'plazo' => 'nullable|integer',
            'interes_bs' => 'nullable|numeric',
            'interes_usd' => 'nullable|numeric',
        ]);
        // Buscar el registro por ID
        $item = TablaDpfs::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->plazo = $request->plazo;
        $item->interes_bs = $request->interes_bs;
        $item->interes_usd = $request->interes_usd;
        $item->save();
        return response()->json(["mensaje" => "Datos actualizados", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = TablaDpfs::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = TablaDpfs::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
