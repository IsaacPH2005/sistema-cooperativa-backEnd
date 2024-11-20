<?php

namespace App\Http\Controllers;

use App\Models\DpfCardWeb;
use Illuminate\Http\Request;

class DpfCardController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = DpfCardWeb::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/dpf_card/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = DpfCardWeb::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/dpf_card/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = DpfCardWeb::find(1);
        if (!$item) {
            return response()->json(["mensaje" => "Cuenta de ahorro no encontrada"], 404);
        }
        $request->validate([
            "titulo" => "required",
            "descripcion" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item->titulo = $request->titulo;
        // Manejar la actualización de la imagen
        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/dpf_card/", $nombreImagen);
            $item->imagen = $nombreImagen; // Asignar la nueva imagen
        }
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
