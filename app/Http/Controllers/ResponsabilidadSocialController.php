<?php

namespace App\Http\Controllers;

use App\Models\ResponsabilidadSocial;
use Illuminate\Http\Request;

class ResponsabilidadSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ResponsabilidadSocial::orderBy('id', 'desc')->paginate(10);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            $item->imagen_pdf = asset('images/responsabilidad_sociales/' . $item->imagen_pdf);
            $item->pdf = asset('pdfs/responsabilidad_sociales/' . $item->pdf);
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
            'titulo' => 'required',
            'subtitulo' => 'required',
            "pdf_1" => 'required|mimes:pdf',
            "pdf_2" => 'required|mimes:pdf',
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $item = new ResponsabilidadSocial();
        $item->titulo = $request->input('titulo');
        $item->subtitulo = $request->input('subtitulo');
        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen_pdf')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen_pdf) {
                unlink('images/responsabilidad_sociales/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/responsabilidad_sociales/", $nombreImagen);
            $item->imagen_pdf = $nombreImagen;
        }
        // Manejar la actualización del PDF
        if ($request->hasFile('pdf_1')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf_1) {
                unlink('pdfs/responsabilidad_sociales/' . $item->pdf_1);
            }
            // Subir el nuevo PDF
            $pdf_1 = $request->file('pdf_1');
            $nombrePdf = time() . '.' . $pdf_1->getClientOriginalExtension();
            $pdf_1->move("pdfs/responsabilidad_sociales/", $nombrePdf);
            $item->pdf_1 = $nombrePdf;
        }
        // Manejar la actualización del PDF
        if ($request->hasFile('pdf_2')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf_2) {
                unlink('pdfs/responsabilidad_sociales/' . $item->pdf_2);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf_2');
            $nombrePdf = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/responsabilidad_sociales/", $nombrePdf);
            $item->pdf_2 = $nombrePdf;
        }
        // Guardar los cambios en la base de datos
        $item->save();
        // Retornar la respuesta JSON con la información actualizada
        return response()->json(['mensaje' => "Registro creado exitosamente", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el registro por ID
        $item = ResponsabilidadSocial::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen_pdf = asset('images/responsabilidad_sociales/' . $item->imagen_pdf);
        $item->pdf_1 = asset('pdfs/responsabilidad_sociales/' . $item->pdf_1);
        $item->pdf_2 = asset('pdfs/responsabilidad_sociales/' . $item->pdf_2);
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
            'titulo' => 'required',
            'subtitulo' => 'required',
            "pdf_1" => 'nullable|mimes:pdf|max:10240',
            "pdf_2" => 'nullable|mimes:pdf|max:10240',
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Buscar el registro por ID
        $item = ResponsabilidadSocial::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        // Actualizar los campos básicos
        $item->titulo = $request->input('titulo');
        $item->subtitulo = $request->input('subtitulo');

        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen_pdf')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen_pdf) {
                unlink('images/responsabilidad_sociales/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/responsabilidad_sociales/", $nombreImagen);
            $item->imagen_pdf = $nombreImagen;
        }

        // Manejar la actualización del PDF 1
        if ($request->hasFile('pdf_1')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf_1) {
                unlink('pdfs/responsabilidad_sociales/' . $item->pdf_1);
            }
            // Subir el nuevo PDF
            $pdf_1 = $request->file('pdf_1');
            $nombrePdf1 = time() . '.' . $pdf_1->getClientOriginalExtension();
            $pdf_1->move("pdfs/responsabilidad_sociales/", $nombrePdf1);
            $item->pdf_1 = $nombrePdf1;
        }

        // Manejar la actualización del PDF 2
        if ($request->hasFile('pdf_2')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf_2) {
                unlink('pdfs/responsabilidad_sociales/' . $item->pdf_2);
            }
            // Subir el nuevo PDF
            $pdf_2 = $request->file('pdf_2');
            $nombrePdf2 = time() . '.' . $pdf_2->getClientOriginalExtension();
            $pdf_2->move("pdfs/responsabilidad_sociales/", $nombrePdf2);
            $item->pdf_2 = $nombrePdf2;
        }

        // Guardar los cambios en la base de datos
        $item->save();

        // Retornar la respuesta JSON con la información actualizada
        return response()->json(['mensaje' => "Registro actualizado exitosamente", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ResponsabilidadSocial::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = ResponsabilidadSocial::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen_pdf = asset('images/responsabilidad_sociales/' . $item->imagen_pdf);
            $item->pdf_1 = asset('pdfs/responsabilidad_sociales/' . $item->pdf_1);
            $item->pdf_2 = asset('pdfs/responsabilidad_sociales/' . $item->pdf_2);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
