<?php

namespace App\Http\Controllers;

use App\Models\bienes_adjudicados; // Asegúrate de que el modelo esté correctamente nombrado
use App\Models\bienes_inmuebles;
use App\Models\Imagenes_Inmuebles;
use App\Models\ImagenesInmuebles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InmueblesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = bienes_inmuebles::orderBy('id', 'desc')->with("imagenes")->paginate(10); // Suponiendo que estás paginando
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
            'rebaja' => 'nullable|integer',
            'datos' => 'required|string',
            'fecha' => 'required|date',
            'imagenes' => 'required|array', // Validate that imagenes is an array
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image
        ]);

        try {
            DB::beginTransaction();

            // Create the bienes_inmuebles record
            $item = new bienes_inmuebles();
            $item->titulo = $request->titulo;
            $item->precio = $request->precio;
            $item->rebaja = $request->rebaja;
            $item->datos = $request->datos;
            $item->fecha = $request->fecha;
            $item->save();

            // Loop through the images and save them
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $file) {
                    // Define the path where the image will be stored
                    $nombreImagen = time() . '_' . uniqid() . '.png'; // Unique name for the image
                    $file->move(public_path("images/inmuebles/"), $nombreImagen); // Move the file to the specified directory

                    // Create a new image record
                    $item2 = new Imagenes_Inmuebles();
                    $item2->imagen = $nombreImagen; // Save the path to the image
                    $item2->bienes_inmueble_id = $item->id; // Set the foreign key
                    $item2->save(); // Save the image record
                }
            }

            DB::commit();
            return response()->json(["mensaje" => "Registro exitoso", "datos" => $item], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "No se pudo realizar el registro: " . $th->getMessage()], 406);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener un solo registro junto con las imágenes
        $item = bienes_inmuebles::with('imagenes')->find($id);

        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        // Convertir las imágenes a URLs completas usando asset()
        $item->imagenes->transform(function ($imagen) {
            $imagen->imagen = asset("images/inmuebles/" . $imagen->imagen);
            return $imagen;
        });

        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'rebaja' => 'nullable|integer',
            'datos' => 'required|string',
            'fecha' => 'required|date',
            'imagenes' => 'nullable|array', // Validate that imagenes is an array
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image
        ]);

        try {
            DB::beginTransaction();
            // Find the bienes_inmuebles record
            $item = bienes_inmuebles::findOrFail($id);
            $item->titulo = $request->titulo;
            $item->precio = $request->precio;
            $item->rebaja = $request->rebaja;
            $item->datos = $request->datos;
            $item->fecha = $request->fecha;
            $item->save();

            // Loop through the images and save them
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $file) {
                    // Define the path where the image will be stored
                    $nombreImagen = time() . '_' . uniqid() . '.png'; // Unique name for the image
                    $file->move(public_path("images/inmuebles/"), $nombreImagen); // Move the file to the specified directory

                    // Create a new image record
                    $item2 = new Imagenes_Inmuebles();
                    $item2->imagen = $nombreImagen; 
                    $item2->bienes_inmueble_id = $item->id; 
                    $item2->save(); 
                }
            }

            DB::commit();
            return response()->json(["mensaje" => "Registro actualizado exitosamente", "datos" => $item], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "No se pudo realizar la actualización: " . $th->getMessage()], 406);
        }
    }
    public function destroy(string $id)
    {
        $item = bienes_inmuebles::find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }

        $item->estado = !$item ->estado; 
        return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 200);
    }

    /**
     * Display a listing of active resources.
     */
    public function indexActivos()
    {
        // Obtener todos los bienes inmuebles con imágenes donde el estado es verdadero
        $items = bienes_inmuebles::with('imagenes')->where('estado', true)->get();
    
        // Transformar las imágenes de cada item
        $items->transform(function ($item) {
            $item->imagenes->transform(function ($imagen) {
                $imagen->imagen = asset("images/inmuebles/" . $imagen->imagen);
                return $imagen;
            });
            return $item;
        });
    
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items], 200);
    }
    public function deleteImage($id)
{
   
    try {
        $image = Imagenes_Inmuebles::findOrFail($id);

        // Obtener la ruta de la imagen para eliminarla del sistema de archivos
        $imagePath = public_path("images/inmuebles/" . $image->imagen);

        // Eliminar la imagen del sistema de archivos
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Eliminar la imagen de la base de datos
        $image->delete();

        return response()->json(["mensaje" => "Imagen eliminada exitosamente"], 200);
    } catch (\Exception $e) {
        return response()->json(["mensaje" => "No se pudo eliminar la imagen: " . $e->getMessage()], 500);
    }
}
}
