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
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = PdfCalificacionDeRiesgos::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/calificacion_de_riesgo/' . $item->pdf);
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
            "pdf" => "nullable|file|mimes:pdf|max:40960", // Validación para PDF
        ]);
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
