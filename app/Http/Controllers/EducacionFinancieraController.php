<?php

namespace App\Http\Controllers;

use App\Models\EducacionFinancieras;
use Illuminate\Http\Request;

class EducacionFinancieraController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = EducacionFinancieras::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "pdf" => "required",
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $item = new EducacionFinancieras();
        $item->nombre = $request->nombre;
        // Manejar la actualización del PDF
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf) {
                unlink('pdfs/educacion_financiera/' . $item->pdf);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf');
            $nombrePdf = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/educacion_financiera/", $nombrePdf);
            $item->pdf = $nombrePdf;
        }
        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen_pdf')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen_pdf) {
                unlink('images/educacion_financiera/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/educacion_financiera/", $nombreImagen);
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
        $item = EducacionFinancieras::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        // Agregar las URLs de la imagen y el PDF
        $item->imagen_pdf = asset('images/educacion_financiera/' . $item->imagen_pdf);
        $item->pdf = asset('pdfs/educacion_financiera/' . $item->pdf);
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
            "pdf" => 'nullable|mimes:pdf|max:10240',
            "imagen_pdf" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
    
        // Buscar el registro por ID
        $item = EducacionFinancieras::find($id);
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
                unlink('images/educacion_financiera/' . $item->imagen_pdf);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen_pdf');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/educacion_financiera/", $nombreImagen);
            $item->imagen_pdf = $nombreImagen;
        }
    
        // Manejar la actualización del PDF 1
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf) {
                unlink('pdfs/educacion_financiera/' . $item->pdf);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf');
            $nombrePdf1 = time() . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/educacion_financiera/", $nombrePdf1);
            $item->pdf = $nombrePdf1;
        }
        // Guardar los cambios en la base de datos
        $item->save();
    
        // Retornar la respuesta JSON con la información actualizada
        return response()->json(['mensaje' => "Registro actualizado exitosamente", "datos" => $item], 200);
    }

    public function destroy(string $id)
    {
        $item = EducacionFinancieras::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = EducacionFinancieras::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen_pdf = asset('images/educacion_financiera/' . $item->imagen_pdf);
            $item->pdf = asset('pdfs/educacion_financiera/' . $item->pdf);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }    
}
