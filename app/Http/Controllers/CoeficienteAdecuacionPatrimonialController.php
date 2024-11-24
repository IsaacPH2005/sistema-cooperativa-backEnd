<?php

namespace App\Http\Controllers;

use App\Models\coeficientes_adecuacion_patrimonial;
use Illuminate\Http\Request;

class CoeficienteAdecuacionPatrimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $items = coeficientes_adecuacion_patrimonial::query();
        if ($search) {
            $items->where(function ($query) use ($search) {
                $query->where('titulo', 'LIKE', '%' . $search . '%')
                    ->orWhere('descripcion', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $items->orderBy("id", "desc")->paginate(15);
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->getCollection()->transform(function ($item) {
            // Agregar la URL de la imagen o una imagen por defecto
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/coeficientes_adecuacion_patrimonial/' . $item->imagen);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/coeficientes_adecuacion_patrimonial/' . $item->pdf);
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
            "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg,webp|max:20480',
            "pdf" => 'required|mimes:pdf|max:10240',
            "descripcion" => 'nullable|string',
        ]);

        $item = new coeficientes_adecuacion_patrimonial();
        $item->titulo = $request->titulo;
        $item->fecha = $request->fecha;
        $item->descripcion = $request->input('descripcion');

        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('images/coeficientes_adecuacion_patrimonial/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/coeficientes_adecuacion_patrimonial/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }

        if ($request->file('pdf')) {
            if ($item->pdf) {
                unlink('pdfs/coeficientes_adecuacion_patrimonial/' . $item->pdf);
            }
            $pdf = $request->file('pdf');
            $nombrePdf = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/coeficientes_adecuacion_patrimonial/", $nombrePdf);
            $item->pdf = $nombrePdf;
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
        $item = coeficientes_adecuacion_patrimonial::find($id);
        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }
        // Agregar la URL de la imagen o una imagen por defecto
        if (!empty($item->imagen)) {
            $item->imagen = asset('images/coeficientes_adecuacion_patrimonial/' . $item->imagen);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
        }
        $item->pdf = asset('pdfs/coeficientes_adecuacion_patrimonial/' . $item->pdf);

        // Retornar la respuesta JSON con el registro encontrado
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            "titulo" => 'required|string|max:255',
            "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
            "pdf" => 'nullable|mimes:pdf|max:40960',
            "fecha" => 'nullable|date',
            "descripcion" => 'nullable|string',
        ]);

        // Buscar el registro por ID
        $item = coeficientes_adecuacion_patrimonial::find($id);

        // Verificar si el registro existe
        if (!$item) {
            return response()->json(["mensaje" => "Registro no encontrado"], 404);
        }

        // Actualizar los campos
        $item->titulo = $request->input('titulo');
        $item->fecha = $request->input('fecha');
        $item->descripcion = $request->input('descripcion');

        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen) {
                unlink('images/coeficientes_adecuacion_patrimonial/' . $item->imagen);
            }
            // Subir la nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/coeficientes_adecuacion_patrimonial/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }

        // Manejar la actualización del PDF
        if ($request->hasFile('pdf')) {
            // Eliminar el PDF anterior si existe
            if ($item->pdf) {
                unlink('pdfs/coeficientes_adecuacion_patrimonial/' . $item->pdf);
            }
            // Subir el nuevo PDF
            $pdf = $request->file('pdf');
            $nombrePdf = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/coeficientes_adecuacion_patrimonial/", $nombrePdf);
            $item->pdf = $nombrePdf;
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
        $item = coeficientes_adecuacion_patrimonial::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = coeficientes_adecuacion_patrimonial::where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            // Agregar la URL de la imagen o una imagen por defecto
            if (!empty($item->imagen)) {
                $item->imagen = asset('images/coeficientes_adecuacion_patrimonial/' . $item->imagen);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
            }
            $item->pdf = asset('pdfs/coeficientes_adecuacion_patrimonial/' . $item->pdf);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
