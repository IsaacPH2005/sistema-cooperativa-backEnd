<?php

namespace App\Http\Controllers;

use App\Models\Testimonios;
use Illuminate\Http\Request;

class TestimoniosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Testimonios::orderBy('id', 'desc')->paginate( 10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre_completo" => "required",
            "rol" => "nullable",
            "testimonio" => "required",
        ]);

        $item = new Testimonios();
        $item->nombre_completo = $request->nombre_completo;
        $item->rol = $request->rol;
        $item->testimonio = $request->testimonio;
        $item->save();
        return response()->json(["mensaje" => "Testimonio creado correctamente"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Testimonios::find($id);
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
            "nombre_completo" => "nullable",
            "rol" => "nullable",
            "testimonio" => "nullable",
        ]);

        $item = Testimonios::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->nombre_completo = $request->nombre_completo;
        $item->rol = $request->rol;
        $item->testimonio = $request->testimonio;
        $item->save();
        return response()->json(["mensaje" => "Testimonio actualizado correctamente"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */ public function destroy(string $id)
    {
        $item = Testimonios::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = Testimonios::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
