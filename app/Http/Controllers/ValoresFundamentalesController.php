<?php

namespace App\Http\Controllers;

use App\Models\ValoresFundamentales;
use Illuminate\Http\Request;

class ValoresFundamentalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ValoresFundamentales::orderBy('id', 'desc')->paginate(5);
        $items->transform(function ($item) {
            // Verificar si la imagen existe y no está vacía
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/valores_fundamentales/' . $item->imagen);
            } else {
                $item->imagen = null; // O puedes omitir esta línea si no quieres incluir la propiedad
            }
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
            "descripcion" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg|max:20480",
        ]);

        $item = new ValoresFundamentales();
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->exists && $item->imagen) {
                $existingImagePath = 'images/valores_fundamentales/' . $item->imagen;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension(); // Usar la extensión original
            $imagen->move("images/valores_fundamentales/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();
        return response()->json(["mensaje" => "Registro creado", "datos" => $item], 201);
    }

    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = ValoresFundamentales::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen = asset('images/valores_fundamentales/' . $item->imagen);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = ValoresFundamentales::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Servicio no encontrado"], 404);
        }
        $request->validate([
            "titulo" => "required",
            "descripcion" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item->titulo = $request->titulo;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->imagen) {
                $existingImagePath = 'images/valores_fundamentales/' . $item->imagen;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/valores_fundamentales/", $nombreImagen);
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
        $item = ValoresFundamentales::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = ValoresFundamentales::where('estado', true)->get();
        $items->transform(function ($item) {
            // Verificar si la imagen existe y no está vacía
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/valores_fundamentales/' . $item->imagen);
            } else {
                $item->imagen = null; // O puedes omitir esta línea si no quieres incluir la propiedad
            }
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
