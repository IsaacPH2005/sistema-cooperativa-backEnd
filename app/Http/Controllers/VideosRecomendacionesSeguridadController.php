<?php

namespace App\Http\Controllers;

use App\Models\VideosRecomendaaciones;
use Illuminate\Http\Request;

class VideosRecomendacionesSeguridadController extends Controller
{
    public function index()
    {
        $videos = VideosRecomendaaciones::orderBy('id', 'desc')->paginate(5);

        // Mapear los items para agregar las URLs de los videos y la información del usuario
        $videos->getCollection()->transform(function ($item) {
            // Suponiendo que $item->video contiene solo el nombre del archivo
            $item->video = asset('videos/RecomendacionesDeSeguridad/' . $item->video);
            // Agregar las URLs de la imagen y el PDF
            if (!empty($item->portada)) {
                $item->portada = asset('portadas/RecomendacionesDeSeguridad/' . $item->portada);
            } else {
                // Asignar una imagen por defecto usando asset
                $item->portada = asset('imagenes_por_defecto/video_icon.png'); // Cambia la ruta según sea necesario
            }
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
            'portada' => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:20480',
            'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:204800',
            'descripcion_del_video' => 'required',
        ]);

        // Crear un nuevo registro en la base de datos
        $item = new VideosRecomendaaciones();
        $item->descripcion_del_video = $request->descripcion_del_video;
        if ($request->file('portada')) {
            $portada = $request->file('portada');
            $nombreportada = md5_file($portada->getPathname()) . '.' . $portada->getClientOriginalExtension();
            $portada->move('portadas/RecomendacionesDeSeguridad', $nombreportada);
            $item->portada = $nombreportada;
        }
        if ($request->file('video')) {
            // Obtener el archivo de la video
            $video = $request->file('video');

            // Generar un nombre único para la video
            $nombrevideo = md5_file($video->getPathname()) . '.' . $video->getClientOriginalExtension();

            // Mover la video a la carpeta correspondiente
            $video->move('videos/RecomendacionesDeSeguridad/', $nombrevideo);

            // Asignar el nombre de la video al objeto
            $item->video = $nombrevideo;
        }
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
        $video = VideosRecomendaaciones::find($id);

        // Verificar si el video existe
        if (!$video) {
            return response()->json(["mensaje" => "Video no encontrado"], 404);
        }

        // Generar la URL del video
        // Agregar las URLs de la imagen y el PDF
        $video->video = asset('videos/RecomendacionesDeSeguridad/' . $video->video);
        // Agregar las URLs de la imagen y el PDF
        if (!empty($video->portada)) {
            $video->portada = asset('portadas/RecomendacionesDeSeguridad/' . $video->portada);
        } else {
            // Asignar una imagen por defecto usando asset
            $video->portada = asset('imagenes_por_defecto/video_icon.png'); // Cambia la ruta según sea necesario
        }

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
        $item = VideosRecomendaaciones::find($id);
        $item->descripcion_del_video = $request->descripcion_del_video;
        // Verificar si el video existe
        if (!$item) {
            return response()->json(["mensaje" => "Video no encontrado"], 404);
        }
        if ($request->file('portada')) {
            // Obtener el archivo de la portada
            $portada = $request->file('portada');
            $nombreportada = md5_file($portada->getPathname()) . '.' . $portada->getClientOriginalExtension();
            $portada->move('portadas/RecomendacionesDeSeguridad/', $nombreportada);

            $item->portada = $nombreportada;
        }
        if ($request->file('video')) {


            // Obtener el archivo de la video
            $video = $request->file('video');

            // Generar un nombre único para la video
            $nombrevideo = md5_file($video->getPathname()) . '.' . $video->getClientOriginalExtension();

            // Mover la video a la carpeta correspondiente
            $video->move('videos/RecomendacionesDeSeguridad/', $nombrevideo);

            // Asignar el nuevo nombre de la video al objeto
            $item->video = $nombrevideo;
        }
        // Guardar los cambios en la base de datos
        $item->save();

        return response()->json(["mensaje" => "Video actualizado", "datos" => $item], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = VideosRecomendaaciones::find($id);
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
        $query = VideosRecomendaaciones::orderBy('id', 'desc')->where('estado', true);
        // Obtener los resultados
        $items = $query->get();

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) {
            $item->video = asset('videos/RecomendacionesDeSeguridad/' . $item->video);
                    // Agregar las URLs de la imagen y el PDF
        if (!empty($item->portada)) {
            $item->portada = asset('portadas/RecomendacionesDeSeguridad/' . $item->portada);
        } else {
            // Asignar una imagen por defecto usando asset
            $item->portada = asset('imagenes_por_defecto/video_icon.png'); // Cambia la ruta según sea necesario
        }

            return $item;
        });

        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
