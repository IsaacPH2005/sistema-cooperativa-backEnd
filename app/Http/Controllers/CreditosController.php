<?php

namespace App\Http\Controllers;

use App\Models\caracteristicas_creditos;
use App\Models\creditos;
use App\Models\requisitos_creditos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreditosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las agencias con sus horarios
        $items = creditos::orderBy('id', 'desc')->with('caracteristicas', 'requisitos')->paginate(10);

        // Definir la URL de la imagen predeterminada
        $defaultImage = asset('images/creditos/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) use ($defaultImage) {
            // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
            $item->imagen = $item->imagen ? asset('images/creditos/' . $item->imagen) : $defaultImage;
            $item->banner_imagen = $item->banner_imagen ? asset('images/creditos/' . $item->banner_imagen) : $defaultImage;

            return $item;
        });

        return response()->json(["mensaje" => "Datos cargados", "datos" => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "descripcion" => "nullable",
            "imagen" => "nullable|mimes:png,jpg,jpeg,gif",
            "banner_imagen" => "nullable|mimes:png,jpg,jpeg,gif", // Corregido
            "cantidad" => "nullable",
            "caracteristicas" => "required|array", // Asegúrate de que sea un array
            "requisitos" => "required|array", // Asegúrate de que sea un array
            "titulo" => "nullable",
            "sub_titulo" => "nullable",
        ]);
        try {
            DB::beginTransaction();
            $item = new creditos();
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->cantidad = $request->cantidad;
            $item->titulo = $request->titulo;
            $item->sub_titulo = $request->sub_titulo;
            if ($request->file('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($item->imagen) {
                    Storage::delete('images/creditos/' . $item->imagen);
                }
                // Obtener el archivo de la imagen
                $imagen = $request->file('imagen');
                // Generar un nombre único para la imagen
                $nombreImagen = time() . '.png';
                // Mover la imagen a la carpeta correspondiente
                $imagen->move("images/creditos/", $nombreImagen);
                // Asignar el nombre de la imagen al objeto
                $item->imagen = $nombreImagen;
            }
            if ($request->file('banner_imagen')) {
                // Eliminar la imagen del banner anterior si existe
                if ($item->banner_imagen) {
                    Storage::delete('images/creditos/' . $item->banner_imagen);
                }
                // Obtener el archivo de la banner imagen
                $bannerImagen = $request->file('banner_imagen'); // Cambiado a 'banner_imagen'
                // Generar un nombre único para la banner imagen
                $nombreBannerImagen = time() . '_banner.png'; // Puedes usar un sufijo para diferenciarlos
                // Mover la banner imagen a la carpeta correspondiente
                $bannerImagen->move("images/creditos/", $nombreBannerImagen);
                // Asignar el nombre de la banner imagen al objeto
                $item->banner_imagen = $nombreBannerImagen; // Cambiado a 'banner_imagen'
            }
            $item->save();
            // Guardar características
            $caracteristicas = $request->caracteristicas ?? []; // Asegúrate de que sea un array
            foreach ($caracteristicas as $caracteristica) {
                if (!empty($caracteristica)) { // Verificar que la característica no esté vacía
                    caracteristicas_creditos::create([
                        'credito_id' => $item->id,
                        'caracteristicas' => $caracteristica,
                    ]);
                }
            }

            // Guardar requisitos
            $requisitos = $request->requisitos ?? []; // Asegúrate de que sea un array
            foreach ($requisitos as $requisito) {
                if (!empty($requisito)) { // Verificar que el requisito no esté vacío
                    requisitos_creditos::create([
                        'credito_id' => $item->id,
                        'requisitos' => $requisito,
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
        $item = creditos::with('caracteristicas', 'requisitos')->find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }

        // Definir la URL de la imagen predeterminada
        $defaultImage = asset('images/creditos/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

        // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
        $item->imagen = $item->imagen ? asset('images/creditos/' . $item->imagen) : $defaultImage;
        $item->banner_imagen = $item->banner_imagen ? asset('images/creditos/' . $item->banner_imagen) : $defaultImage;

        // Devolver el item con la URL de la imagen
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }
    public function show2(string $id)
    {
        // Buscar el crédito por su ID
        $item = creditos::with('caracteristicas', 'requisitos')->find($id);

        // Verificar si el item existe
        if (!$item) {
            return response()->json(["mensaje" => "item no encontrada"], 404);
        }

        // Definir la URL de la imagen predeterminada
        $defaultImage = asset('images/creditos/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

        // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
        $item->imagen = $item->imagen ? asset('images/creditos/' . $item->imagen) : $defaultImage;
        $item->banner_imagen = $item->banner_imagen ? asset('images/creditos/' . $item->banner_imagen) : $defaultImage;

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
        "nombre" => "nullable",
        "descripcion" => "nullable",
        "imagen" => "nullable|mimes:png,jpg,jpeg,gif",
        "banner_imagen" => "nullable|mimes:png,jpg,jpeg,gif",
        "cantidad" => "nullable",
        "caracteristicas" => "nullable|array",
        "requisitos" => "nullable|array",
        "titulo" => "nullable",
        "sub_titulo" => "nullable",
    ]);

    try {
        DB::beginTransaction();

        // Buscar el crédito por su ID
        $item = creditos::findOrFail($id);

        // Actualizar solo los campos que están presentes en la solicitud
        $item->nombre = $request->input('nombre', $item->nombre);
        $item->descripcion = $request->input('descripcion', $item->descripcion);
        $item->cantidad = $request->input('cantidad', $item->cantidad);
        $item->titulo = $request->input('titulo', $item->titulo);
        $item->sub_titulo = $request->input('sub_titulo', $item->sub_titulo);

        // Manejar la imagen
        if ($request->file('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($item->imagen) {
                Storage::delete('images/creditos/' . $item->imagen);
            }
            // Obtener el archivo de la imagen
            $imagen = $request->file('imagen');
            // Generar un nombre único para la imagen
            $nombreImagen = time() . '.png';
            // Mover la imagen a la carpeta correspondiente
            $imagen->move("images/creditos/", $nombreImagen);
            // Asignar el nombre de la imagen al objeto
            $item->imagen = $nombreImagen;
        }

        // Manejar la banner imagen
        if ($request->file('banner_imagen')) {
            // Eliminar la imagen del banner anterior si existe
            if ($item->banner_imagen) {
                Storage::delete('images/creditos/' . $item->banner_imagen);
            }
            // Obtener el archivo de la banner imagen
            $bannerImagen = $request->file('banner_imagen');
            // Generar un nombre único para la banner imagen
            $nombreBannerImagen = time() . '_banner.png';
            // Mover la banner imagen a la carpeta correspondiente
            $bannerImagen->move("images/creditos/", $nombreBannerImagen);
            // Asignar el nombre de la banner imagen al objeto
            $item->banner_imagen = $nombreBannerImagen;
        }

        // Guardar los cambios en el crédito
        $item->save();

        // Actualizar características
        // Primero, eliminamos las características existentes
        caracteristicas_creditos::where('credito_id', $item->id)->delete();
        // Luego, agregamos las nuevas características
        foreach ($request->caracteristicas ?? [] as $caracteristica) {
            caracteristicas_creditos::create([
                'credito_id' => $item->id,
                'caracteristicas' => $caracteristica,
            ]);
        }

        // Actualizar requisitos
        // Primero, eliminamos los requisitos existentes
        requisitos_creditos::where('credito_id', $item->id)->delete();
        // Luego, agregamos los nuevos requisitos
        foreach ($request->requisitos ?? [] as $requisito) {
            requisitos_creditos::create([
                'credito_id' => $item->id,
                'requisitos' => $requisito,
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
        $item = creditos::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos(Request $request)
    {
        // Obtener el término de búsqueda de los parámetros de la solicitud
        $searchTerm = $request->input('search');

        // Obtener los créditos activos con sus características y requisitos
        $query = creditos::with('caracteristicas', 'requisitos')->where('estado', true);

        // Aplicar el filtro de búsqueda si hay un término de búsqueda
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('descripcion', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Obtener los resultados
        $items = $query->get();

        // Mapear los items para agregar las URLs de las imágenes
        $items->transform(function ($item) {
            // Definir la URL de la imagen predeterminada
            $defaultImage = asset('images/creditos/img_default.jpg'); // Cambia la ruta según tu estructura de archivos

            // Asignar la imagen si existe, de lo contrario, usar la imagen predeterminada
            $item->imagen = $item->imagen ? asset('images/creditos/' . $item->imagen) : $defaultImage;
            $item->banner_imagen = $item->banner_imagen ? asset('images/creditos/' . $item->banner_imagen) : $defaultImage;

            return $item;
        });

        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
