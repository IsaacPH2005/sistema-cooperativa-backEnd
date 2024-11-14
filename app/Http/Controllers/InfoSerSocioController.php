<?php

namespace App\Http\Controllers;

use App\Models\InfoSerSocio;
use App\Models\OpcionesDeSerSocios;
use Illuminate\Http\Request;

class InfoSerSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = InfoSerSocio::findOrFail(1);
        return response()->json($item, 200);
    }
    public function indexActivo()
    {
        $item = InfoSerSocio::findOrFail(1);
        return response()->json($item, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function actualizarDatos(Request $request)
    {
        $request->validate([
            "titulo" => "required|string",
            "sub_titulo" => "required|string",
        ]);

        $item = InfoSerSocio::findOrFail(1);
        $item->titulo = $request->titulo;
        $item->sub_titulo = $request->sub_titulo;
        $item->save();

        return response()->json(["mensaje" => "Datos actualizados correctamente"], 200);
    }
}
