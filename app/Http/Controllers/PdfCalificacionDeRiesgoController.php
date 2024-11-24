<?php

namespace App\Http\Controllers;

use App\Models\PdfCalificacionDeRiesgos;
use Illuminate\Http\Request;

class PdfCalificacionDeRiesgoController extends Controller
{
    public function index()
    {
        $item = PdfCalificacionDeRiesgos::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/calificacion_de_riesgo/' . $item->pdf);
        }
        // Agregar la URL de la imagen o una imagen por defecto
        if (!empty($item->imagen)) {
            $item->imagen = asset('images/calificacion_de_riesgo/' . $item->imagen);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = PdfCalificacionDeRiesgos::findOrFail(1);

        // Agregar las URLs de los archivos PDF
        if ($item->pdf) {
            $item->pdf = asset('pdfs/calificacion_de_riesgo/' . $item->pdf);
        }

        // Agregar la URL de la imagen o una imagen por defecto
        if (!empty($item->imagen)) {
            $item->imagen = asset('images/calificacion_de_riesgo/' . $item->imagen);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->imagen = asset('imagenes_por_defecto/pdf.png'); // Cambia la ruta según sea necesario
        }

        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = PdfCalificacionDeRiesgos::find(1);
        if (!$item) {
            return response()->json(["mensaje" => "Cuenta de ahorro no encontrada"], 404);
        }
        $request->validate([
            "titulo" => "required",
            "imagen" => "nullable|image|mimes:jpeg,png,jpg,webp|max:20480", // Validación para imágenes
            "pdf" => "nullable|file|mimes:pdf|max:40960", // Validación para PDF
        ]);
        $item->titulo = $request->titulo;
        // Manejar la actualización de la imagen
        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/calificacion_de_riesgo/", $nombreImagen);
            $item->imagen = $nombreImagen; // Asignar la nueva imagen
        }
        // Manejar la actualización de la pdf
        if ($request->file('pdf')) {
            $pdf = $request->file('pdf');
            $nombrepdf = md5_file($pdf->getPathname()) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move("pdfs/calificacion_de_riesgo/", $nombrepdf);
            $item->pdf = $nombrepdf; // Asignar la nueva pdf
        }
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
