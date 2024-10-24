<?php

namespace App\Http\Controllers;

use App\Models\bienes_adjudicados; // Asegúrate de que el modelo esté correctamente nombrado
use Illuminate\Http\Request;

class InmueblesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = bienes_adjudicados::paginate(10); // Suponiendo que estás paginando

        // Decodificar las imágenes para cada item
        foreach ($items as $item) {
            $item->imagenes = json_decode($item->imagenes); // Convertir a array
            // Generar las URLs completas para cada imagen
            if ($item->imagenes) {
                $item->imagenes = array_map(function ($imagen) {
                    return asset('images/inmuebles/' . $imagen); // Generar URL completa
                }, $item->imagenes);
            }
        }

        return response()->json(["mensaje" => "Datos cargados", "datos" => $items], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'rebaja' => 'required|integer',
            'datos' => 'required|string',
            'fecha' => 'required|date',
            'imagenes' => 'required|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validar que cada imagen sea válida
        ]);

        $item = new bienes_adjudicados();
        $item->titulo = $request->titulo;
        $item->precio = $request->precio;
        $item->rebaja = $request->rebaja;
        $item->datos = $request->datos;
        $item->fecha = $request->fecha;
        // Guardar imágenes
        $imagenesPaths = [];
        foreach ($request->imagenes as $imagen) {
            // Si existe una imagen anterior, eliminarla (opcional)
            // Aquí puedes implementar la lógica de eliminación si es necesario
            // if ($item->imagen) {
            //     unlink('images/inmuebles/' . $item->imagen);
            // }

            // Procesar la nueva imagen
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension(); // Generar un nombre único
            $imagen->move("images/inmuebles/", $nombreImagen); // Mover la imagen al directorio

            $imagenesPaths[] = $nombreImagen; // Almacenar el nombre de la imagen
        }

        // Guardar rutas como JSON
        $item->imagenes = json_encode($imagenesPaths);
        $item->save();

        return response()->json(["mensaje" => "Registro creado", "datos" => $item], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = bienes_adjudicados::find($id); // Obtener un solo registro
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
    
        // Decodificar las imágenes para el item
        $item->imagenes = json_decode($item->imagenes); // Convertir a array
    
        // Generar las URLs completas para cada imagen
        if ($item->imagenes) {
            $item->imagenes = array_map(function ($imagen) {
                return asset('images/inmuebles/' . $imagen); // Generar URL completa
            }, $item->imagenes);
        }
    
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $item = bienes_adjudicados::find($id);
    if (!$item) {
        return response()->json(['mensaje' => "No se encontró el registro"], 404);
    }

    // Validar los datos entrantes
    $request->validate([
        'titulo' => 'sometimes|required|string|max:255',
        'precio' => 'sometimes|required|numeric',
        'rebaja' => 'sometimes|required|integer',
        'datos' => 'sometimes|required|string',
        'fecha' => 'sometimes|required|date',
        'imagenes' => 'sometimes|array',
        'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validar que cada imagen sea válida
    ]);

    // Actualizar los campos permitidos
    $item->titulo = $request->input('titulo', $item->titulo);
    $item->precio = $request->input('precio', $item->precio);
    $item->rebaja = $request->input('rebaja', $item->rebaja);
    $item->datos = $request->input('datos', $item->datos);
    $item->fecha = $request->input('fecha', $item->fecha);

    // Manejar las imágenes si se proporcionan
    if ($request->has('imagenes')) {
        $imagenesPaths = json_decode($item->imagenes, true); // Obtener las imágenes existentes

        // Subir nuevas imágenes
        foreach ($request->imagenes as $imagen) {
            // Generar un nombre único para la imagen
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension(); // Generar un nombre único
            $imagen->move("images/inmuebles/", $nombreImagen); // Mover la imagen al directorio

            $imagenesPaths[] = $nombreImagen; // Agregar la nueva ruta al array
        }

        // Guardar las rutas de las imágenes actualizadas
        $item->imagenes = json_encode($imagenesPaths);
    }

    // Guardar los cambios en la base de datos
    $item->save();

    return response()->json(["mensaje" => "Registro actualizado", "datos" => $item], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = bienes_adjudicados::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        $item->delete(); // Eliminar el registro
        return response()->json(["mensaje" => "Registro eliminado exitosamente"], 200);
    }

    /**
     * Display a listing of active resources.
     */
    public function indexActivos()
    {
        $items = bienes_adjudicados::where('estado', true)->get();
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items], 200);
    }
}
