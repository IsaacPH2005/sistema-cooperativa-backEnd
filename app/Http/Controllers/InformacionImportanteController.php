<?php

namespace App\Http\Controllers;

use App\Models\InformacionImportante;
use Illuminate\Http\Request;

class InformacionImportanteController extends Controller
{
    public function index()
    {
        $item = InformacionImportante::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen_1) {
            $item->imagen_1 = asset('images/informacion_importante/' . $item->imagen_1);
        }
        // Agregar las URLs de las imágenes
        if ($item->imagen_2) {
            $item->imagen_2 = asset('images/informacion_importante/' . $item->imagen_2);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = InformacionImportante::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen_1) {
            $item->imagen_1 = asset('images/informacion_importante/' . $item->imagen_1);
        }
        // Agregar las URLs de las imágenes
        if ($item->imagen_2) {
            $item->imagen_2 = asset('images/informacion_importante/' . $item->imagen_2);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = InformacionImportante::find(1);
        $request->validate([
            "imagen_1" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
            "imagen_2" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        // Manejar la actualización de la imagen
        if ($request->file('imagen_1')) {
            $imagen_1 = $request->file('imagen_1');
            $nombreImagen = md5_file($imagen_1->getPathname()) . '.' . $imagen_1->getClientOriginalExtension();
            $imagen_1->move("images/informacion_importante/", $nombreImagen);
            $item->imagen_1 = $nombreImagen; // Asignar la nueva imagen
        }
        // Manejar la actualización de la imagen
        if ($request->file('imagen_2')) {
            $imagen_2 = $request->file('imagen_2');
            $nombreImagen = md5_file($imagen_2->getPathname()) . '.' . $imagen_2->getClientOriginalExtension();
            $imagen_2->move("images/informacion_importante/", $nombreImagen);
            $item->imagen_2 = $nombreImagen; // Asignar la nueva imagen
        }
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
