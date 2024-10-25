<?php

namespace App\Http\Controllers;

use App\Models\Imagenes_Inmuebles;
use Illuminate\Http\Request;

class ImagensInmueblesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Imagenes_Inmuebles::orderBy('id', 'desc')->get();
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "imagen" => "required|image|mimes:jpeg,png,jpg",
        ]);

        
        $item = new Imagenes_Inmuebles();
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('images/bienes_inmuebles/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.png';
            $imagen->move("images/bienes_inmuebles/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();

        return response()->json(["mensaje" => "Imagen cargada correctamente", "datos" => $item], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
