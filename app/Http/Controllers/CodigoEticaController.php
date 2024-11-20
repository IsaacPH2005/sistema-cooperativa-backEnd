<?php

namespace App\Http\Controllers;

use App\Models\CodigoDeEtica;
use Illuminate\Http\Request;

class CodigoEticaController extends Controller
{
    public function index()
    {
        $item = CodigoDeEtica::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/codigo_etica/' . $item->pdf);
        }
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = CodigoDeEtica::findOrFail(1);
        // Agregar las URLs de las imágenes
        if ($item->pdf) {
            $item->pdf = asset('pdfs/codigo_etica/' . $item->pdf);
        }
        return response()->json($item, 200);
    }
    public function update(Request $request)
    {
        $item = CodigoDeEtica::find(1);
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
            $pdf->move("pdfs/codigo_etica/", $nombrepdf);
            $item->pdf = $nombrepdf; // Asignar la nueva pdf
        }
        $item->save();
        return response()->json(["mensaje" => "Registro actualizado con éxito", "datos" => $item], 200);
    }
}
