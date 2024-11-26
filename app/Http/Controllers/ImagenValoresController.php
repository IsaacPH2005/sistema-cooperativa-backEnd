<?php

namespace App\Http\Controllers;

use App\Models\ImagenValoresFundamentales;
use Illuminate\Http\Request;

class ImagenValoresController extends Controller
{
    public function index()
    {
        $item = ImagenValoresFundamentales::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/valores_fundamentales/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = ImagenValoresFundamentales::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/valores_fundamentales/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = ImagenValoresFundamentales::find(1);
        $request->validate([
            "nombre_de_la_imagen" => 'required',
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item->nombre_de_la_imagen = $request->nombre_de_la_imagen;
        // Manejar la actualización de la imagen
        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/valores_fundamentales/", $nombreImagen);
            $item->imagen = $nombreImagen; // Asignar la nueva imagen
        }
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
