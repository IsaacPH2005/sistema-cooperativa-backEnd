<?php

namespace App\Http\Controllers\api\CuentaDeAhorro;

use App\Http\Controllers\Controller;
use App\Models\CuentaDeAhorro;
use Illuminate\Http\Request;

class CuentadeAhorroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = CuentaDeAhorro::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/cuenta_de_ahorro/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = CuentaDeAhorro::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->imagen) {
            $item->imagen = asset('images/cuenta_de_ahorro/' . $item->imagen);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = CuentaDeAhorro::find(1);
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
            $imagen->move("images/cuenta_de_ahorro/", $nombreImagen);
            $item->imagen = $nombreImagen; // Asignar la nueva imagen
        }
        $item->descripcion = $request->descripcion;
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
