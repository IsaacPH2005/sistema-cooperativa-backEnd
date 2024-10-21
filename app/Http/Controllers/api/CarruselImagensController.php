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
        $item = carrusel_imagenes::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "imagen" => "mimes:png,jpg,jpeg"
        ]);
        $item = new carrusel_imagenes();
        $item->nombre = $request->nombre;
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
        $item = carrusel_imagenes::find($id);
        $imagen = asset('img/img_batchs/' . $item->imagen);
        if ($item) {
            return response()->json(["mensaje" => "Registro cargado", "datos" => $item, "imagen" => $imagen], 200);
        } else {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required",
        ]);
        $item = carrusel_imagenes::find($id);
        $item->nombre = $request->nombre;
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
        $item->is_deleted = !$item->is_deleted;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function imagenesActivas()
    {
        $items = carrusel_imagenes::where('is_deleted', false)->orderBy('id', 'desc')->get();
        $items->transform(function ($item) {
            $imagenPath = 'img/img_carrusel/' . $item->imagen;
            $item->imagen = file_exists($imagenPath) ? asset($imagenPath) : null;
            return $item;
        });
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items]);
    }
}
