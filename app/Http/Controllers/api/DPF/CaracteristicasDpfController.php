<?php

namespace App\Http\Controllers\api\DPF;

use App\Http\Controllers\Controller;
use App\Models\CaracteristicasDpf;
use Illuminate\Http\Request;

class CaracteristicasDpfController extends Controller
{
    public function index()
    {
        $items = CaracteristicasDpf::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "descripcion" => "required",
        ]);
        $item = new CaracteristicasDpf();
        $item->titulo = $request->titulo; 
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Característica creada", "datos" => $item], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = CaracteristicasDpf::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Característica no encontrada"], 404);
        }
        return response()->json(["mensaje" => "Característica cargada", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titulo' => 'nullable|string|max:255', // Add validation
            "descripcion" => "required",
        ]);
        $item = CaracteristicasDpf::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Característica no encontrada"], 404);
        }
        $item->titulo = $request->titulo; 
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Característica actualizada", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = CaracteristicasDpf::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = CaracteristicasDpf::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
