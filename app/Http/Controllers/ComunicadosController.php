<?php

namespace App\Http\Controllers;

use App\Models\comunicados;
use Illuminate\Http\Request;

class ComunicadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = comunicados::orderBy('id', 'desc')->paginate(10);
                // Mapear los items para agregar las URLs de las imágenes
                $items->getCollection()->transform(function ($item) {
                    // Agregar la URL de la imagen
                    $item->imagen = asset('images/comunicados/' . $item->imagen);
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
            "titulo" => "nullable",
            "descripcion" => "nullable",
            "imagen" => "required|image|mimes:jpeg,png,jpg,gif,webp|max:20480", // Permitir varios formatos de imagen
            "url" => "nullable",
        ]);

        $item = new comunicados();
        $item->titulo = $request->input('titulo');
        $item->descripcion = $request->input('descripcion');
        $item->url = $request->input('url');
        // Manejo de la imagen
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('images/comunicados/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/comunicados/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();

        return response()->json(["mensaje" => "Datos guardados", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el crédito por su ID
        $item = comunicados::find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }

        // Definir la URL de la imagen predeterminada
        $defaultImage = ''; // Cambia la ruta según tu estructura de archivos

        // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
        $item->imagen = $item->imagen ? asset('images/comunicados/' . $item->imagen) : $defaultImage;
        // Devolver el item con la URL de la imagen
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "titulo" => "nullable",
            "descripcion" => "nullable",
            "url" => "nullable",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480", // Permitir varios formatos de imagen
        ]);

        $item = comunicados::find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }

        $item->titulo = $request->input('titulo');
        $item->descripcion = $request->input('descripcion');
        $item->url = $request->input('url');

        // Manejo de la imagen
        if ($request->file('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen) {
                unlink('images/comunicados/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/comunicados/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }

        $item->save();

        return response()->json(["mensaje" => "Datos actualizados", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = comunicados::find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }
        $item->estado = !$item->estado;
        $item->save();

        return response()->json(["mensaje" => "Estado modificado "], 200);
    }
    public function indexActivos()
    {
        $items = comunicados::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen = asset('images/comunicados/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
