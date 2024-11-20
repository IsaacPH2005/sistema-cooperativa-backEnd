<?php

namespace App\Http\Controllers;

use App\Models\servicios;
use Illuminate\Http\Request;

class ServiciosBasicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $items = servicios::query();
        if ($search) {
            $items->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $items->orderBy("id", "desc")->paginate(15);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            $item->imagen = asset('images/servicios_basicos/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "datos cargados", "datos" => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "imagen" => "required|image|mimes:jpeg,png,jpg,webp||max:20480",
        ]);
        $item = new servicios();
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->exists && $item->imagen) {
                $existingImagePath = 'images/servicios_basicos/' . $item->foto;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
    
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/servicios_basicos/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();

        return response()->json(["mensaje" => "Servicio creado con éxito", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = servicios::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen = asset('images/servicios_basicos/' . $item->imagen);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = servicios::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Servicio no encontrado"], 404);
        }
        $request->validate([
            "nombre" => "required",
            "imagen" => "image|mimes:jpeg,png,jpg,webp||max:20480",
        ]);
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->imagen) {
                $existingImagePath = 'images/servicios_basicos/' . $item->imagen;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
    
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/servicios_basicos/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();

        return response()->json(["mensaje" => "Servicio actualizado con éxito", "datos" => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = servicios::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = servicios::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen = asset('images/servicios_basicos/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
