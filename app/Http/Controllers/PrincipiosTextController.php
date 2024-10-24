<?php

namespace App\Http\Controllers;

use App\Models\principios_text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrincipiosTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function lecturaitem()
    {
        try {
            $item = principios_text::findOrFail(1);
            return response()->json($item, 200);
        } catch (\Throwable $e) {
            // Registrar el error para depuración
            return response()->json("existe un error:" . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function edicionPrincipiosText(Request $request)
    {
        try {
            $item = principios_text::find(1);

            $validator = Validator::make($request->all(), [
                'principios_fundamentales' => 'nullable',
                'principios_cooperativos' => 'nullable',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $simpleErrors = [];
                foreach ($errors as $key => $messages) {
                    $simpleErrors[$key] = $messages[0];
                }
                return response()->json($simpleErrors, 422);
            }

            // Actualizar otros campos
            $item->principios_fundamentales = nl2br($request->principios_fundamentales);
            $item->principios_cooperativos = nl2br($request->principios_cooperativos);
            $item->save();

            return response()->json($item, 200); // Retorna la empresa actualizada
        } catch (\Throwable $e) {
            return response()->json("existe un error: " . $e->getMessage(), 500);
        }
    }
}
