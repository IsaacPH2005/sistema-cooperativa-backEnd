<?php

namespace App\Http\Controllers;

use App\Models\contactanos;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel; // Asegúrate de importar Excel
use App\Exports\ContactanosExport; // Asegúrate de importar tu clase de exportación

class ContactanosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generateExcel()
    {
        try {
            return Excel::download(new ContactanosExport, 'contactos.xlsx'); // Genera y descarga el archivo Excel
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error generando el Excel: ' . $e->getMessage()], 500);
        }
    }
    public function generatePDF()
    {
        try {
            // Obtener todos los contactos
            $contactos = contactanos::all();

            // Crear una instancia de PDF
            $pdf = app('dompdf.wrapper'); // Usa el contenedor de Laravel para obtener la instancia

            // Cargar la vista para el PDF con todos los contactos
            $pdf->loadView('pdf.contactos', ['contactos' => $contactos]);

            // Descargar el PDF
            return $pdf->download('contactos.pdf');
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['mensaje' => 'Error generando el PDF: ' . $e->getMessage()], 500);
        }
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $item = contactanos::where('nombre', 'like', "%{$search}%")->orderBy('id', 'desc')->paginate(10);
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo_electronico' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        // Guarda el mensaje en la base de datos
        $item =  new contactanos();
        $item->nombre = $request->nombre;
        $item->apellidos = $request->apellidos;
        $item->correo_electronico = $request->correo_electronico;
        $item->telefono = $request->telefono;
        $item->mensaje = $request->mensaje;
        $item->save();
        // Enviar correo electrónico
        /*  Mail::send('emails.contacto', ['mensaje' => $item->mensaje, 'nombre' => $item->nombre], function ($message) use ($item) {
            $message->from('parisacahuallpaisaac@gmail.com', 'Isaac Parisaca');
            $message->to($item->correo_electronico, $item->nombre);
            $message->subject('Mensaje desde la aplicación');
        }); */
        return response()->json(["mensaje" => "Envio Exitoso", "datos" => $item], 200);
    }
    public function destroy(string $id)
    {
        $contactanos = contactanos::find($id);
        if ($contactanos) {
            $contactanos->delete();
            return response()->json(["mensaje" => "Contacto eliminado con éxito"], 200);
        } else {
            return response()->json(["mensaje" => "Contacto no encontrado"], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function countContactanos()
    {
        $total = contactanos::count();
        return response()->json(["mensaje" => "Total de contactanos", "total" => $total], 200);
    }
    public function sendEmail(string $id)
    {
        $contactanos = contactanos::find($id);
        if ($contactanos) {
            $email = $contactanos->correo_electronico;
            $nombre = $contactanos->nombre . ' ' . $contactanos->apellidos;
            $mensaje = 'Este es un mensaje de prueba desde la aplicación';

            try {
                Mail::send('emails.contacto', ['mensaje' => $mensaje, 'nombre' => $nombre], function ($message) use ($email, $nombre) {
                    $message->from('parisacahuallpaisaac@gmail.com', 'Isaac');
                    $message->to($email, $nombre);
                    $message->subject('Mensaje desde la aplicación');
                });

                return response()->json(["mensaje" => "Email enviado con éxito"], 200);
            } catch (\Exception $e) {
                return response()->json(["mensaje" => "Error al enviar el email: " . $e->getMessage()], 500);
            }
        } else {
            return response()->json(["mensaje" => "Contacto no encontrado"], 404);
        }
    }
}
