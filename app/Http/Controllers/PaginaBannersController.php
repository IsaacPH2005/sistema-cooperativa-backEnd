<?php

namespace App\Http\Controllers;

use App\Models\paginas;
use App\Models\paginas_banners;
use Illuminate\Support\Facades\Storage; // Add this line
use Illuminate\Http\Request;

class PaginaBannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = paginas_banners::with('paginas')->paginate(20);
        foreach ($item as $paginaBanner) {
            $paginaBanner->imagen = asset('images/paginas_banners/' . $paginaBanner->imagen);
        }
        return response()->json(['mensaje' => "Datos cargados con exito", "datos" => $item]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "pagina_id" => 'required|unique:paginas_banners,pagina_id',
            "imagen" => 'required|mimes:jpg,png,jpeg,gif,svg,webp|max:20480'
        ]);

        $item = new paginas_banners();
        $item->pagina_id = $request->pagina_id;
        $item->titulo = $request->titulo;
        $item->subtitulo = $request->subtitulo;
        if ($request->file('imagen')) {
            if ($item->imagen) {
                unlink('images/paginas_banners/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/paginas_banners/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();
        return response()->json(['mensaje' => "Registro exitoso", "datos" => $item], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = paginas_banners::with('paginas')->find($id);
        if (!$item) {
            return response()->json(['mensaje' => "No se encontró el registro"], 404);
        }
        $item->imagen = asset('images/paginas_banners/' . $item->imagen);
        return response()->json(['mensaje' => "Registro encontrado", "datos" => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "pagina_id" => 'sometimes|required|unique:paginas_banners,pagina_id,' . $id . ',id',
            "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg,webp|max:20480'
        ]);

        $item = paginas_banners::find($id);
        if ($request->has('pagina_id')) {
            $item->pagina_id = $request->pagina_id;
        }
        $item->titulo = $request->titulo;
        $item->subtitulo = $request->subtitulo;
        if ($request->file('imagen')) {
            if ($item->imagen) {
                Storage::delete('public/images/paginas_banners/' . $item->imagen);
            }
            $imagen = $request->file('imagen');
            $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move("images/paginas_banners/", $nombreImagen);
            $item->imagen = $nombreImagen;
        }
        $item->save();
        return response()->json(['mensaje' => "Registro exitoso", "datos" => $item], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = paginas_banners::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado modificado", "datos" => $item], 202);
        } else {
            return response()->json(["mensaje" => "No se pudo modifcar el estado"], 422);
        }
    }
    public function paginasBannersActivos(Request $request)
{
    // Validar que el campo 'nombre' es obligatorio
/*     $request->validate([
        "nombre" => "required"
    ]); */

    // Obtener el nombre de la solicitud
    $nombre = $request->nombre;

    // Buscar la página por nombre
    $pagina = paginas::where('nombre', 'LIKE', '%' . $nombre . '%')->with('paginas_banners')->first();

    // Verificar si se encontró la página
    if (!$pagina) {
        return response()->json(['mensaje' => "No se encontró la página"], 404);
    }

    // Cargar los banners de la página
    if ($pagina->paginas_banners->count() > 0) {
        $pagina->paginas_banners->each(function ($banner) {
            $banner->imagen = asset('images/paginas_banners/' . $banner->imagen);
        });
    }

    // Obtener los banners que están activos
    $items = paginas_banners::where('estado', true) // Asumiendo que 'estado' indica si está activo
        ->with('paginas') // Cargar la relación 'paginas'
        ->orderBy('id', 'desc')
        ->get();

    // Transformar los items para agregar la URL de la imagen
    $items->transform(function ($item) {
        $imagenPath = public_path('images/paginas_banners/' . $item->imagen); // Ruta de la imagen
        $item->imagen = file_exists($imagenPath) ? asset('images/paginas_banners/' . $item->imagen) : null; // Verificar si la imagen existe
        return $item; // Retornar el item transformado
    });

    return response()->json(["mensaje" => "Datos cargados", "datos" => $items]);
}
    
}
