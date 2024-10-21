<?php

namespace App\Http\Controllers;

use App\Models\Paginas;
use Illuminate\Http\Request;

class PaginasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Paginas::all();
        return response()->json(["mensaje" => "Datos cargados", "datos" => $item]);
    }
    public function showByName(Request $request)
    {
        $request->validate(
            [
                "nombre" => "required"
            ]
        );
        $nombre = $request->nombre;
        $item = Paginas::where('nombre', 'LIKE', $nombre)->with('paginas_banners')->firstOr();

        if ($item->paginas_banners->count() > 0) {
            $item->paginas_banners->each(function ($banner) {
                $banner->imagen = asset('images/paginas_banners/' . $banner->imagen);
            });
        }

        return response()->json(["mensaje" => "Datos cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
