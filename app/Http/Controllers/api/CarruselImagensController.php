<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\carrusel_imagenes;
use Illuminate\Http\Request;

class CarruselImagensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = carrusel_imagenes::orderBy('id', 'desc')->paginate(10);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            $item->imagen = asset('img/img_carrusel/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titulo" => "required",
            "imagen" => "mimes:png,jpg,jpeg"
        ]);
        $item = new carrusel_imagenes();
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('img/img_carrusel/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.png';
            $imagen->move("img/img_carrusel/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        if ($item->save()) {
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "No se pudo realizar el registro"], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = carrusel_imagenes::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen = asset('img/img_carrusel/' . $item->imagen);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "titulo" => "required",
            "imagen" => "mimes:png,jpg,jpeg"
        ]);
        $item = carrusel_imagenes::find($id);
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('img/img_carrusel/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.png';
            $imagen->move("img/img_carrusel/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        if ($item->save()) {
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "No se pudo realizar el registro"], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = carrusel_imagenes::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function imagenesActivas()
    {
        $items = carrusel_imagenes::where('estado', true)->orderBy('id', 'desc')->get();
        $items->transform(function ($item) {
            $imagenPath = 'img/img_carrusel/' . $item->imagen;
            $item->imagen = file_exists($imagenPath) ? asset($imagenPath) : null;
            return $item;
        });
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items]);
    }
}
