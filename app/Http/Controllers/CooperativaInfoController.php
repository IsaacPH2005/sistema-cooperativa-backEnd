<?php

namespace App\Http\Controllers;

use App\Models\CooperativaInfo;
use Illuminate\Http\Request;

class CooperativaInfoController extends Controller
{
    
    public function index()
    {
        $item = CooperativaInfo::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/cooperativa_info/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = CooperativaInfo::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/cooperativa_info/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = CooperativaInfo::find(1);
        if (!$item) {
            return response()->json(["mensaje" => "Cuenta de ahorro no encontrada"], 404);
        }
        $request->validate([
            "titulo" => "required",
            "descripcion" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg|max:20480",
        ]);
        $item->titulo = $request->titulo;
        // Manejar la actualización de la imagen
        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/cooperativa_info/", $nombreImagen);
            $item->imagen = $nombreImagen; // Asignar la nueva imagen
        }
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
