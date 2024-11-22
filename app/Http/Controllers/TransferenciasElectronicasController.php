<?php

namespace App\Http\Controllers;

use App\Models\Transferencias_electronicas;
use Illuminate\Http\Request;

class TransferenciasElectronicasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $items = Transferencias_electronicas::query();
        if ($search) {
            $items->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $items->orderBy("id", "desc")->paginate(15);
        $items->transform(function ($item) {
            // Verificar si la imagen existe y no está vacía
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/transferencias_electronicas/' . $item->imagen);
            } else {
                $item->imagen = null; // O puedes omitir esta línea si no quieres incluir la propiedad
            }
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
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item = new Transferencias_electronicas();
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->exists && $item->imagen) {
                $existingImagePath = 'images/transferencias_electronicas/' . $item->imagen;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/transferencias_electronicas/", $nombreImagen);
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
        $item = Transferencias_electronicas::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen = asset('images/transferencias_electronicas/' . $item->imagen);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Transferencias_electronicas::find($id);
        if (!$item) {
            return response()->json(["mensaje" => "Servicio no encontrado"], 404);
        }
        $request->validate([
            "nombre" => "required",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480",
        ]);
        $item->nombre = $request->nombre;
        $item->descripcion = $request->descripcion;
        if ($request->file('imagen')) {
            // Verificar si hay una foto existente antes de guardar la nueva
            if ($item->imagen) {
                $existingImagePath = 'images/transferencias_electronicas/' . $item->imagen;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/transferencias_electronicas/", $nombreImagen);
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
        $item = Transferencias_electronicas::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = Transferencias_electronicas::where('estado', true)->get();
        $items->transform(function ($item) {
            // Verificar si la imagen existe y no está vacía
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/transferencias_electronicas/' . $item->imagen);
            } else {
                $item->imagen = null; // O puedes omitir esta línea si no quieres incluir la propiedad
            }
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
