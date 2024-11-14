<?php

namespace App\Http\Controllers;

use App\Models\EducacionFinancierasImagenes;
use Illuminate\Http\Request;

class EducacionFinancierasImg extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = EducacionFinancierasImagenes::orderBy('id', 'desc')->paginate(10);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            $item->imagen = asset('images/educacion_financieras_imagenes/' . $item->imagen);
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
            "imagen" => 'required|mimes:jpg,png,jpeg,gif,svg',
            "nombre" => "required",
        ]);
        $item = new EducacionFinancierasImagenes();
        $item->nombre = $request->input('nombre');
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('images/educacion_financieras_imagenes/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/educacion_financieras_imagenes/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();
        return response()->json(["mensaje" => "Imagen creada", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = EducacionFinancierasImagenes::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen = asset('images/educacion_financieras_imagenes/' . $item->imagen);
        // Retornar la respuesta JSON con la información del registro
        return response()->json(["mensaje" => "Registro cargado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required',
            "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg',
        ]);

        // Buscar el registro por ID
        $item = EducacionFinancierasImagenes::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        // Actualizar los campos básicos
        $item->nombre = $request->input('nombre');
        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen) {
                unlink('images/educacion_financieras_imagenes/' . $item->imagen);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/educacion_financieras_imagenes/", $nombreImagen);
            $item->imagen = $nombreImagen;
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
        $item = EducacionFinancierasImagenes::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = EducacionFinancierasImagenes::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen = asset('images/educacion_financieras_imagenes/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
