<?php

namespace App\Http\Controllers;

use App\Models\LicitacionPublicas;
use Illuminate\Http\Request;

class LicitacionPublicasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = LicitacionPublicas::orderBy('id', 'desc')->paginate(10);
           // Mapear los items para agregar las URLs de las imágenes y PDFs
           $items->getCollection()->transform(function ($item) {
            if (!empty($item->imagen_pdf)) {
                $item->imagen_pdf = asset('images/licitacion_publica/' . $item->imagen_pdf);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen_pdf = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/licitacion_publica/' . $item->pdf);
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
            "nombre" => "required",
            "pdf" => "required|mimes:pdf|max:40960",
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:20480',
        ]);
        $item = new LicitacionPublicas();
        $item->nombre = $request->nombre;
        // Manejar la actualización del PDF
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf) {
                unlink('pdfs/licitacion_publica/' . $item->pdf);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf');
            $nombrePdf = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/licitacion_publica/", $nombrePdf);
            $item->pdf = $nombrePdf;
        }
        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen_pdf')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen_pdf) {
                unlink('images/licitacion_publica/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/licitacion_publica/", $nombreImagen);
            $item->imagen_pdf = $nombreImagen;
        }
        $item->save();
        return response()->json(["mensaje" => "Licitación publica creada", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = LicitacionPublicas::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
         // Agregar la URL de la imagen o una imagen por defecto
         if (!empty($item->imagen_pdf)) {
            $item->imagen_pdf = asset('images/licitacion_publica/' . $item->imagen_pdf);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->imagen_pdf = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
        }
        $item->pdf = asset('pdfs/licitacion_publica/' . $item->pdf);
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
            "pdf" => 'nullable|mimes:pdf|max:40960',
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg,webp|max:20480',
        ]);
    
        // Buscar el registro por ID
        $item = LicitacionPublicas::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
    
        // Actualizar los campos básicos
        $item->nombre = $request->input('nombre');
        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen_pdf')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen_pdf) {
                unlink('images/licitacion_publica/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/licitacion_publica/", $nombreImagen);
            $item->imagen_pdf = $nombreImagen;
        }
    
        // Manejar la actualización del PDF 1
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf) {
                unlink('pdfs/licitacion_publica/' . $item->pdf);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf');
            $nombrePdf1 = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/licitacion_publica/", $nombrePdf1);
            $item->pdf = $nombrePdf1;
        }
        // Guardar los cambios en la base de datos
        $item->save();
    
        // Retornar la respuesta JSON con la información actualizada
        return response()->json(['mensaje' => "Registro actualizado exitosamente", "datos" => $item], 200);
    }

    public function destroy(string $id)
    {
        $item = LicitacionPublicas::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = LicitacionPublicas::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            if (!empty($item->imagen_pdf)) {
                $item->imagen_pdf = asset('images/licitacion_publica/' . $item->imagen_pdf);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen_pdf = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/licitacion_publica/' . $item->pdf);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
