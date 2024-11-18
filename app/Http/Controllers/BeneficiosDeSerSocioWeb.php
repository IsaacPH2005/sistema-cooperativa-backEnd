<?php

namespace App\Http\Controllers;

use App\Models\BeneficiosDeSerSocios;
use Illuminate\Http\Request;

class BeneficiosDeSerSocioWeb extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = BeneficiosDeSerSocios::orderBy('id', 'desc')->paginate(5);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "beneficio" => 'required'
        ]);
        $item = new BeneficiosDeSerSocios();
        $item->beneficio = $request->beneficio;
        $item->save();
        return response()->json(["mensaje" => "Beneficio creado", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = BeneficiosDeSerSocios::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Beneficio no encontrado"], 404);
        }
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "beneficio" => 'nullable'
        ]);
        $item = BeneficiosDeSerSocios::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Beneficio no encontrado"], 404);
        }
        $item->beneficio = $request->beneficio;
        $item->save();
        return response()->json(["mensaje" => "Beneficio actualizado", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = BeneficiosDeSerSocios::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = BeneficiosDeSerSocios::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
