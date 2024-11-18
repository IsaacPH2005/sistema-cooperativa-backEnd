<?php

namespace App\Http\Controllers;

use App\Models\TasasYTarifas;
use Illuminate\Http\Request;

class TasasYTarifaController extends Controller
{
    public function index()
    {
        $item = TasasYTarifas::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/tasas_y_tarifa/' . $item->pdf);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = TasasYTarifas::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/tasas_y_tarifa/' . $item->pdf);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = TasasYTarifas::find(1);
        if (!$item) {
            return response()->json(["mensaje" => "Cuenta de ahorro no encontrada"], 404);
        }
        $request->validate([
            "pdf" => "nullable|file|mimes:pdf|max:40960", // Validación para PDF
        ]);
        // Manejar la actualización de la pdf
        if ($request->file('pdf')) {
            $pdf = $request->file('pdf');
            $nombrepdf = time() . '.' . $pdf->getClientOriginalExtension(); // Usar la extensión original
            $pdf->move("pdfs/tasas_y_tarifa/", $nombrepdf);
            $item->pdf = $nombrepdf; // Asignar la nueva pdf
        }
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
