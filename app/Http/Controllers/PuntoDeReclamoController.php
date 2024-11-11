<?php

namespace App\Http\Controllers;

use App\Exports\PuntoDeReclamoExport;
use App\Models\PuntoDeReclamo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PuntoDeReclamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $items = PuntoDeReclamo::orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_del_hecho' => 'required|date|before_or_equal:today',
            'agencia' => 'required',
            'descripcion' => 'required',
            'tipo_persona' => 'required',
            'nombre_o_razon_social' => 'required',
            'numero_de_documento' => 'required',
            'celular' => 'required',
            'correo_electronico' => 'required',
            'direccion' => 'required',
            'complemento' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        $item = new PuntoDeReclamo();
        // Asignar los valores del request al objeto
        $item->fill($request->all());
        $item->save();

        // Devolver el ID del reclamo guardado
        return response()->json(['id' => $item->id], 201);
    }
    // Método para generar el PDF
    public function generatePDFID($id)
    {
        try {
            $item = PuntoDeReclamo::findOrFail($id);
            return $this->generatePDFUsuario($item);
        } catch (ModelNotFoundException $e) {
            return response()->json(['mensaje' => 'Reclamo no encontrado.'], 404);
        }
    }
    private function generatePDFUsuario($item)
    {
        try {
            // Crear una instancia de PDF
            $pdf = app('dompdf.wrapper'); // Usa el contenedor de Laravel para obtener la instancia

            // Configurar el tamaño y la orientación de la página
            $pdf->setPaper('Legal', 'landscape'); // 'Legal' para tamaño oficio y 'landscape' para orientación horizontal

            // Cargar la vista para el PDF con todos los contactos
            $pdf->loadView('pdf.Punto_de_reclamo', ['PuntoDeReclamo' => $item]);

            // Descargar el PDF
            return $pdf->download('PuntoDeReclamo.pdf');
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['mensaje' => 'Error generando el PDF: ' . $e->getMessage()], 500);
        }
    }

    public function generateExcel()
    {
        try {
            return Excel::download(new PuntoDeReclamoExport, 'Punto-de-Reclamos.xlsx'); // Genera y descarga el archivo Excel
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error generando el Excel: ' . $e->getMessage()], 500);
        }
    }
    public function generatePDF()
    {
        try {
            // Obtener todos los contactos
            $items = PuntoDeReclamo::all();

            // Crear una instancia de PDF
            $pdf = app('dompdf.wrapper'); // Usa el contenedor de Laravel para obtener la instancia

            // Configurar el tamaño y la orientación de la página
            $pdf->setPaper('Legal', 'landscape'); // 'Legal' para tamaño oficio y 'landscape' para orientación horizontal

            // Cargar la vista para el PDF con todos los contactos
            $pdf->loadView('pdf.PuntoDeReclamos', ['PuntoDeReclamos' => $items]);

            // Descargar el PDF
            return $pdf->download('PuntoDeReclamos.pdf');
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['mensaje' => 'Error generando el PDF: ' . $e->getMessage()], 500);
        }
    }
    public function show(string $id)
    {
        $item = PuntoDeReclamo::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'fecha_del_hecho' => 'required|date|before_or_equal:today',
            'agencia' => 'required',
            'descripcion' => 'required',
            'tipo_persona' => 'required',
            'nombre_o_razon_social' => 'required',
            'numero_de_documento' => 'required',
            'celular' => 'required',
            'correo_electronico' => 'required',
            'direccion' => 'required',
            'complemento' => 'required',
        ]);

        // Buscar el registro por ID
        $item = PuntoDeReclamo::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        // Actualizar los campos del registro
        $item->fecha_del_hecho = $request->fecha_del_hecho;
        $item->categoria = $request->categoria;
        $item->sub_categoria = $request->sub_categoria;
        $item->monto_comprometido = $request->monto_comprometido;
        $item->opciones_multiples_1 = $request->opciones_multiples_1;
        $item->agencia = $request->agencia;
        $item->descripcion = $request->descripcion;
        $item->tipo_persona = $request->tipo_persona;
        $item->representante_legal = $request->representante_legal;
        $item->numero_de_testimonio = $request->numero_de_testimonio;
        $item->nombre_o_razon_social = $request->nombre_o_razon_social;
        $item->numero_de_documento = $request->numero_de_documento;
        $item->opciones_multiples_2 = $request->opciones_multiples_2;
        $item->complemento = $request->complemento;
        $item->expedido_en = $request->expedido_en;
        $item->celular = $request->celular;
        $item->correo_electronico = $request->correo_electronico;
        $item->direccion = $request->direccion;
        $item->medio_de_envio_de_respuesta = $request->medio_de_envio_de_respuesta;
        $item->telefono_fijo = $request->telefono_fijo;
        $item->recibir_numero_de_reclamo = $request->recibir_numero_de_reclamo;

        // Guardar los cambios
        $item->save();

        return response()->json(["mensaje" => "Registro actualizado", "datos" => $item], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = PuntoDeReclamo::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = PuntoDeReclamo::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
    public function inactivosActivos()
    {
        $items = PuntoDeReclamo::where('estado', false)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
