<?php

namespace App\Http\Controllers;

use App\Models\TablaCalificacionDeRiesgos;
use Illuminate\Http\Request;

class TablaCalificacionDeRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = TablaCalificacionDeRiesgos::findOrFail(1);
        return response()->json($item, 200);
    }
    public function index2()
    {
        $item = TablaCalificacionDeRiesgos::findOrFail(1);
        return response()->json($item, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'date',
        ]);
        $item = new TablaCalificacionDeRiesgos();
        $item->celda_1 = $request->celda_1;
        $item->celda_2 = $request->celda_2;
        $item->celda_3 = $request->celda_3;
        $item->celda_4 = $request->celda_4;
        $item->celda_5 = $request->celda_5;
        $item->celda_6 = $request->celda_6;
        $item->celda_7 = $request->celda_7;
        $item->celda_8 = $request->celda_8; 
        $item->celda_9 = $request->celda_9;
        $item->celda_10 = $request->celda_10;
        $item->fecha = $request->fecha;
        $item->save();
        return response()->json($item, 201);
    }
    public function estado(){
        $item = TablaCalificacionDeRiesgos::findOrFail(1);
        $item->estado =!$item->estado;
        $item->save();
        return response()->json($item, 200);
    }
}
