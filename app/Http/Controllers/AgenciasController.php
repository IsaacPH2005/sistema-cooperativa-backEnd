<?php

namespace App\Http\Controllers;

use App\Models\agencias;
use App\Models\horarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las agencias con sus horarios
        $items = agencias::orderBy('id', 'desc')->with('horarios')->paginate(10);

        // Mapear los items para agregar las URLs de las imágenes
        $items->getCollection()->transform(function ($item) {
            // Agregar la URL de la imagen
            $item->imagen = asset('images/agencias/' . $item->imagen);
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
            'nombre' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_mapa' => 'nullable|url', // Validar que sea una URL válida
            'dias' => 'required|array', // Cambiar a array
            'dias.*' => 'string', // Validar que cada elemento sea una cadena
            'horas' => 'required|array', // Cambiar a array
            'horas.*' => 'string', // Validar que cada elemento sea una cadena
        ]);

        try {
            DB::beginTransaction();

            // Crear el registro de agencias
            $item = new agencias();
            $item->nombre = $request->nombre;
            $item->calle = $request->calle;
            $item->telefono = $request->telefono;
            $item->url_mapa = $request->url_mapa; // Recibir la URL del mapa desde la solicitud
            if ($request->file('imagen')) {
                if ($item->imagen) {
                    unlink('images/agencias/' . $item->imagen);
                }
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '.png';
                $imagen->move("images/agencias/", $nombreImagen);
                $item->imagen = $nombreImagen;
            }
            $item->save();

            // Crear registros en horarios
            $dias = $request->dias; // Esto ahora es un arreglo
            $horas = $request->horas; // Esto ahora es un arreglo
            foreach ($dias as $key => $dia) {
                $item2 = new horarios();
                $item2->agencia_id = $item->id; // Establecer la clave foránea
                $item2->dias = $dia; // Asignar el día correspondiente
                $item2->horas = isset($horas[$key]) ? $horas[$key] : null; // Asignar la hora correspondiente
                $item2->save(); // Guardar el registro de horarios
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
        // Buscar la agencia por su ID
        $agencia = agencias::with('horarios')->find($id);

        // Verificar si la agencia existe
        if (!$agencia) {
            return response()->json(["mensaje" => "Agencia no encontrada"], 404);
        }

        // Construir la URL de la imagen
        if ($agencia->imagen) {
            $agencia->imagen_url = asset('images/agencias/' . $agencia->imagen);
        } else {
            $agencia->imagen_url = null; // O puedes asignar una imagen por defecto
        }

        // Devolver la agencia con la URL de la imagen
        return response()->json(["mensaje" => "Datos cargados", "datos" => $agencia], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'calle' => 'required|string',
            'telefono' => 'nullable|string|max:255',
            'url_mapa' => 'nullable|url', // Validar que sea una URL válida
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Cambié 'imagenes' a 'imagen'
            'dias' => 'required|array', // Cambié a array
            'horas' => 'required|array', // Cambié a array
        ]);

        try {
            DB::beginTransaction();

            // Buscar el registro de la agencia
            $item = agencias::findOrFail($id);
            $item->nombre = $request->nombre;
            $item->calle = $request->calle;
            $item->telefono = $request->telefono;
            $item->url_mapa = $request->url_mapa; // Recibir la URL del mapa desde la solicitud

            // Manejo de la imagen
            if ($request->file('imagen')) {
                if ($item->imagen) {
                    unlink('images/agencias/' . $item->imagen);
                }
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '.png';
                $imagen->move("images/agencias/", $nombreImagen);
                $item->imagen = $nombreImagen;
            }

            $item->save();

            // Actualizar horarios
            // Primero, elimina los horarios existentes
            horarios::where('agencia_id', $item->id)->delete();

            // Luego, crea nuevos registros de horarios
            $dias = $request->dias; // Asegúrate de que esto sea un array
            $horas = $request->horas; // Asegúrate de que esto sea un array
            foreach ($dias as $key => $dia) {
                $item2 = new horarios();
                $item2->agencia_id = $item->id; // Set the foreign key
                $item2->dias = $dia; // Asigna el día correspondiente
                $item2->horas = isset($horas[$key]) ? $horas[$key] : null; // Asigna la hora correspondiente
                $item2->save(); // Guarda el registro de horarios
            }

            DB::commit();
            return response()->json(["mensaje" => "Registro actualizado exitosamente", "datos" => $item], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["mensaje" => "No se pudo realizar la actualización: " . $th->getMessage()], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = agencias::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function indexActivos()
    {
        $items = agencias::with('horarios')->where('estado', true)->get();
        // Mapear los items para agregar las URLs de las imágenes y PDFs
        $items->transform(function ($item) {
            $item->imagen = asset('images/agencias/' . $item->imagen);
            return $item;
        });
        return response()->json(["mensaje" => "Datos activos cargados", "datos" => $items]);
    }
}
