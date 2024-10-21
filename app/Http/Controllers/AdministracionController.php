<?php

namespace App\Http\Controllers;

use App\Models\administraciones;
use Illuminate\Http\Request;

class AdministracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $items = administraciones::query();
        if ($search) {
            $items->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', '%' . $search . '%')
                    ->orWhere('apellido', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $items->orderBy("id", "desc")->paginate(15);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            $item->foto = asset('images/administracion_personal/' . $item->foto);
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
            "nombre" => 'required',
            "apellido" => 'required',
            "cargo" => 'required',
            "foto" => 'required|image|mimes:jpeg,png,jpg',
        ]);
        $item = new administraciones();
        $item->nombre = $request->nombre;
        $item->apellido = $request->apellido;
        $item->cargo = $request->cargo;
        if ($request->file('foto')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->exists && $item->foto) {
                $existingImagePath = 'images/administracion_personal/' . $item->foto;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
    
            $imagen = $request->file('foto');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension(); // Usar la extensión original
            $imagen->move("images/administracion_personal/", $nombreImagen);
            $item->foto = $nombreImagen;
        }
        $item->save();
        return response()->json(['mensaje' => "Registro exitoso", "datos" => $item], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = administraciones::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->foto = asset('images/administracion_personal/' . $item->foto);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => 'required',
            "apellido" => 'required',
            "cargo" => 'required',
            "foto" => 'image|mimes:jpeg,png,jpg',
        ]);
        $item = administraciones::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->nombre = $request->nombre;
        $item->apellido = $request->apellido;
        $item->cargo = $request->cargo;
        // Manejar la actualización de la imagen
        if ($request->hasFile('foto')) {
            // Eliminar la imagen anterior si existe
            if ($item->foto) {
                unlink('images/administracion_personal/' . $item->foto);
            }
            // Subir la nueva imagen
            $imagen = $request->file('foto');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/administracion_personal/", $nombreImagen);
            $item->foto = $nombreImagen;
        }
        $item->save();
        // Retornar la respuesta JSON con la información actualizada
        return response()->json(['mensaje' => "Registro actualizado exitosamente", "datos" => $item], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = administraciones::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = administraciones::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->foto = asset('images/administracion_personal/' . $item->foto);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
