<?php

namespace App\Http\Controllers;

use App\Models\VideosEducacionFinancieras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoEducacionFinancieraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = VideosEducacionFinancieras::with(['creator', 'modifier'])->orderBy('id', 'desc')->paginate(5);

        // Mapear los items para agregar las URLs de los videos y la información del usuario
        $videos->getCollection()->transform(function ($item) {
            // Suponiendo que $item->video contiene solo el nombre del archivo
            $item->video = asset('videos/EducacionFinanciera/' . $item->video);
            $item->portada = asset('portadas/EducacionFinanciera/' . $item->portada);

            // Agregar la información del creador y modificador
            $item->creator_name = $item->creator ? $item->creator->nombre : 'Desconocido'; // Cambia 'name' por el campo que desees mostrar
            $item->modifier_name = $item->modifier ? $item->modifier->nombre : 'Desconocido'; // Cambia 'name' por el campo que desees mostrar

            return $item;
        });

        return response()->json(["mensaje" => "Datos cargados", "datos" => $videos], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:204800',
            'descripcion_del_video' => 'required',
            'portada' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:20480'
        ]);

        // Crear un nuevo registro en la base de datos
        $item = new VideosEducacionFinancieras();
        $item->descripcion_del_video = $request->descripcion_del_video;
        if ($request->file('portada')) {
            $portada = $request->file('portada');
            $nombreportada = md5_file($portada->getPathname()) . '.' . $portada->getClientOriginalExtension();
            $portada->move('portadas/EducacionFinanciera', $nombreportada);
            $item->portada = $nombreportada;
        }
        if ($request->file('video')) {
            // Obtener el archivo de la video
            $video = $request->file('video');

            // Generar un nombre único para la video
            $nombrevideo = md5_file($video->getPathname()) . '.' . $video->getClientOriginalExtension();

            // Mover la video a la carpeta correspondiente
            $video->move('videos/EducacionFinanciera/', $nombrevideo);

            // Asignar el nombre de la video al objeto
            $item->video = $nombrevideo;
        }
        // Asignar el ID del usuario que crea el video
        $item->created_by = auth()->id(); // Asumiendo que estás usando autenticación de Laravel

        // Guardar el nuevo registro en la base de datos
        $item->save();

        return response()->json($item, 201); // Retornar el objeto guardado
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el video por ID
        $video = VideosEducacionFinancieras::find($id);

        // Verificar si el video existe
        if (!$video) {
            return response()->json(["mensaje" => "Video no encontrado"], 404);
        }

        // Generar la URL del video
        // Agregar las URLs de la imagen y el PDF
        $video->video = asset('videos/EducacionFinanciera/' . $video->video);
        $video->portada = asset('portadas/EducacionFinanciera/' . $video->portada);

        return response()->json(["mensaje" => "Video encontrado", "datos" => $video], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar el archivo (opcional si no se sube un nuevo video)
        $request->validate([
            'video' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:204800', // Hacerlo opcional
            'descripcion_del_video' => 'nullable',
            'portada' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:20480'
        ]);

        // Buscar el video por ID
        $item = VideosEducacionFinancieras::find($id);
        $item->descripcion_del_video = $request->descripcion_del_video;
        // Verificar si el video existe
        if (!$item) {
            return response()->json(["mensaje" => "Video no encontrado"], 404);
        }
        if ($request->file('portada')) {
            // Obtener el archivo de la portada
            $portada = $request->file('portada');
            $nombreportada = md5_file($portada->getPathname()) . '.' . $portada->getClientOriginalExtension();
            $portada->move('portadas/EducacionFinanciera/', $nombreportada);

            $item->portada = $nombreportada;
        }
        if ($request->file('video')) {


            // Obtener el archivo de la video
            $video = $request->file('video');

            // Generar un nombre único para la video
            $nombrevideo = md5_file($video->getPathname()) . '.' . $video->getClientOriginalExtension();

            // Mover la video a la carpeta correspondiente
            $video->move('videos/EducacionFinanciera/', $nombrevideo);

            // Asignar el nuevo nombre de la video al objeto
            $item->video = $nombrevideo;
        }
        // Aquí puedes actualizar otros campos si es necesario

        // Asignar el ID del usuario que modifica el video
        $item->updated_by = auth()->id(); // Asumiendo que estás usando autenticación de Laravel

        // Guardar los cambios en la base de datos
        $item->save();

        return response()->json(["mensaje" => "Video actualizado", "datos" => $item], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = VideosEducacionFinancieras::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos(Request $request)
    {
        // Obtener los créditos activos con sus características y requisitos
        $query = VideosEducacionFinancieras::orderBy('id', 'desc')->where('estado', true);
        // Obtener los resultados
        $items = $query->get();

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) {
            $item->video = asset('videos/EducacionFinanciera/' . $item->video);
            $item->portada = asset('portadas/EducacionFinanciera/' . $item->portada);
            return $item;
        });

        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
