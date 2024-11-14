<?php

namespace App\Http\Controllers;

use App\Models\RecomendacionesDeSeguridad;
use App\Models\SeguridadTips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SeguridadTipsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las agencias con sus horarios
        $items = SeguridadTips::orderBy('id', 'desc')->with('recomendaciones')->paginate(10);

        // Definir la URL de la imagen predeterminada
        $defaultImage = asset('images/seguridad_tips/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) use ($defaultImage) {
            // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
            $item->imagen = $item->imagen ? asset('images/seguridad_tips/' . $item->imagen) : $defaultImage;
            return $item;
        });

        return response()->json(["mensaje" => "Datos cargados", "datos" => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "titulo" => "required",
            "imagen" => "required|mimes:png,jpg,jpeg,gif",
            "recomendaciones" => "required|array", // Asegúrate de que sea un array
        ]);
        try {
            DB::beginTransaction();
            $item = new SeguridadTips();
            $item->titulo = $request->titulo;
            if ($request->file('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($item->imagen) {
                    Storage::delete('images/seguridad_tips/' . $item->imagen);
                }
                // Obtener el archivo de la imagen
                $imagen = $request->file('imagen');
                // Generar un nombre único para la imagen
                $nombreImagen = time() . '.png';
                // Mover la imagen a la carpeta correspondiente
                $imagen->move("images/seguridad_tips/", $nombreImagen);
                // Asignar el nombre de la imagen al objeto
                $item->imagen = $nombreImagen;
            }
            $item->save();
            // Guardar recomendaciones
            $recomendaciones = $request->recomendaciones ?? []; // Asegúrate de que sea un array
            foreach ($recomendaciones as $recomendacion) {
                if (!empty($recomendacion)) { // Verificar que la recomendación no esté vacía
                    RecomendacionesDeSeguridad::create([
                        'seguridad_id' => $item->id,
                        'recomendacion' => $recomendacion, // Asegúrate de que este campo sea correcto
                    ]);
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
        // Buscar el crédito por su ID
        $item = SeguridadTips::with('recomendaciones')->find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }

        // Definir la URL de la imagen predeterminada
        $defaultImage = asset('images/seguridad_tips/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

        // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
        $item->imagen = $item->imagen ? asset('images/seguridad_tips/' . $item->imagen) : $defaultImage;
        // Devolver el item con la URL de la imagen
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar la solicitud
        $request->validate([
            "titulo" => "nullable",
            "imagen" => "nullable|mimes:png,jpg,jpeg,gif",
            "recomendaciones" => "nullable|array",
        ]);

        try {
            DB::beginTransaction();

            // Buscar el crédito por su ID
            $item = SeguridadTips::findOrFail($id);
            $item->titulo = $request->input('titulo', $item->titulo);

            // Manejar la imagen
            if ($request->file('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($item->imagen) {
                    Storage::delete('images/seguridad_tips/' . $item->imagen);
                }
                // Obtener el archivo de la imagen
                $imagen = $request->file('imagen');
                // Generar un nombre único para la imagen
                $nombreImagen = time() . '.png';
                // Mover la imagen a la carpeta correspondiente
                $imagen->move("images/seguridad_tips/", $nombreImagen);
                // Asignar el nombre de la imagen al objeto
                $item->imagen = $nombreImagen;
            }

            // Guardar los cambios en el crédito
            $item->save();

            RecomendacionesDeSeguridad::where('seguridad_id', $item->id)->delete();
            // Luego, agregamos las nuevas recomendaciones
            foreach ($request->recomendaciones ?? [] as $recomendacion) {
                RecomendacionesDeSeguridad::create([
                    'seguridad_id' => $item->id,
                    'recomendacion' => $recomendacion,
                ]);
            }

            DB::commit();
            return response()->json(["mensaje" => "Registro actualizado exitosamente", "datos" => $item], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "No se pudo actualizar el registro: " . $th->getMessage()], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = SeguridadTips::find($id);
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
        $query = SeguridadTips::with('recomendaciones')->where('estado', true);
        // Obtener los resultados
        $items = $query->get();

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) {
            // Definir la URL de la imagen predeterminada
            $defaultImage = asset('images/seguridad_tips/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

            // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
            $item->imagen = $item->imagen ? asset('images/seguridad_tips/' . $item->imagen) : $defaultImage;

            return $item;
        });

        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
