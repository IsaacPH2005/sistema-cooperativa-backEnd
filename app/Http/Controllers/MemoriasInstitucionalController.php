<?php

namespace App\Http\Controllers;

use App\Models\memorias_institucionales;
use Illuminate\Http\Request;

class MemoriasInstitucionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = memorias_institucionales::query();
        $items = $items->orderBy("id", "desc")->paginate(15);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/memorias_institucionales/' . $item->imagen);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/memorias_institucionales/' . $item->pdf);
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
            "titulo" => 'required|string|max:255',
            "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:20480',
            'pdf' => 'required|mimes:pdf|max:40960',
            'fecha' => 'nullable|date|after:today', // La fecha debe ser después de hoy
            "descripcion" => 'nullable|string',
        ]);

        $memoria = new memorias_institucionales();
        $memoria->titulo = $request->input('titulo');
        $memoria->fecha = $request->input('fecha');
        $memoria->descripcion = $request->input('descripcion');

        if ($request->file('imagen')) {
            if ($memoria->imagen) {
                unlink('images/memorias_institucionales/' . $memoria->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/memorias_institucionales/", $nombreImagen);
            $memoria->imagen = $nombreImagen;
        }

        if ($request->file('pdf')) {
            if ($memoria->pdf) {
                unlink('pdfs/memorias_institucionales/' . $memoria->pdf);
            }
            $pdf = $request->file('pdf');
            $nombrePdf = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/memorias_institucionales/", $nombrePdf);
            $memoria->pdf = $nombrePdf;
        }

        $memoria->save();

        return response()->json(['mensaje' => "Registro exitoso", "datos" => $memoria], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = memorias_institucionales::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
           // Agregar la URL de la imagen o una imagen por defecto
           if (!empty($item->imagen)) {
            $item->imagen = asset('images/memorias_institucionales/' . $item->imagen);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
        }
        $item->pdf = asset('pdfs/memorias_institucionales/' . $item->pdf);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }
    public function update(Request $request, string $id)
{
    // Validar los datos de entrada
    $request->validate([
        "titulo" => 'required|string|max:255',
        "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:20480',
        "pdf" => 'nullable|mimes:pdf|max:40960',
        "descripcion" => 'nullable|string',
        'fecha' => 'nullable|date|after:today', // La fecha debe ser después de hoy
    ]);

    // Buscar el registro por ID
    $memoria = memorias_institucionales::find($id);

    // Verificar si el registro existe
    if (!$memoria) {
        return response()->json(["mensaje" => "Registro no encontrado"], 404);
    }

    // Actualizar los campos
    $memoria->titulo = $request->input('titulo');
    $memoria->fecha = $request->input('fecha');
    $memoria->descripcion = $request->input('descripcion');

    // Manejar la actualización de la imagen
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen anterior si existe
        if ($memoria->imagen) {
            unlink('images/memorias_institucionales/' . $memoria->imagen);
        }
        // Subir la nueva imagen
        $imagen = $request->file('imagen');
        $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
        $imagen->move("images/memorias_institucionales/", $nombreImagen);
        $memoria->imagen = $nombreImagen;
    }

    // Manejar la actualización del PDF
    if ($request->hasFile('pdf')) {
        // Eliminar el PDF anterior si existe
        if ($memoria->pdf) {
            unlink('pdfs/memorias_institucionales/' . $memoria->pdf);
        }
        // Subir el nuevo PDF
        $pdf = $request->file('pdf');
        $nombrePdf = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
        $pdf->move("pdfs/memorias_institucionales/", $nombrePdf);
        $memoria->pdf = $nombrePdf;
    }

    // Guardar los cambios en la base de datos
    $memoria->save();

    // Retornar la respuesta JSON con la información actualizada
    return response()->json(['mensaje' => "Registro actualizado exitosamente", "datos" => $memoria], 200);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = memorias_institucionales::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = memorias_institucionales::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/memorias_institucionales/' . $item->imagen);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/memorias_institucionales/' . $item->pdf);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
