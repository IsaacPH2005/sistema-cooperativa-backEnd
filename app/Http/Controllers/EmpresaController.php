<?php

namespace App\Http\Controllers;

use App\Models\empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    public function lecturaEmpresa()
    {
        try {
            $empresa = Empresa::findOrFail(1);
            // Agregar las URLs de las imágenes
            if ($empresa->imagen) {
                $empresa->imagen = asset('images/empresa/' . $empresa->imagen);
            }
            if ($empresa->asfi_imagen) {
                $empresa->asfi_imagen = asset('images/empresa/' . $empresa->asfi_imagen);
            }
            if ($empresa->logo) {
                $empresa->logo = asset('images/empresa/' . $empresa->logo);
            }
            return response()->json($empresa, 200);
        } catch (\Throwable $e) {
            // Registrar el error para depuración
            return response()->json("existe un error:" . $e->getMessage(), 500);
        }
    }
    public function lecturaEmpresa2()
    {
        try {
            $empresa = Empresa::findOrFail(1);
            // Agregar las URLs de las imágenes
            if ($empresa->imagen) {
                $empresa->imagen = asset('images/empresa/' . $empresa->imagen);
            }
            if ($empresa->asfi_imagen) {
                $empresa->asfi_imagen = asset('images/empresa/' . $empresa->asfi_imagen);
            }
            if ($empresa->logo) {
                $empresa->logo = asset('images/empresa/' . $empresa->logo);
            }
            return response()->json($empresa, 200);
        } catch (\Throwable $e) {
            // Registrar el error para depuración
            return response()->json("existe un error:" . $e->getMessage(), 500);
        }
    }

    public function edicionWebEmpresas(Request $request)
    {
        try {
            $empresa = Empresa::find(1);

            $validator = Validator::make($request->all(), [
                'mision' => 'required',
                'vision' => 'required',
                'historia' => 'required',
                'aspecto_legal' => 'required',
                // Descomentar y ajustar si deseas validar las imágenes
                "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
                "asfi_imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
                "logo" => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
                "direccion" => 'nullable',
                "celular" => 'nullable',
                "email" => 'nullable|email',
                "latitud" => 'nullable',
                "longitud" => 'nullable',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $simpleErrors = [];
                foreach ($errors as $key => $messages) {
                    $simpleErrors[$key] = $messages[0];
                }
                return response()->json($simpleErrors, 422);
            }

            // Manejar la actualización de la imagen
            if ($request->file('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension(); // Usar la extensión original
                $imagen->move("images/empresa/", $nombreImagen);
                $empresa->imagen = $nombreImagen; // Asignar la nueva imagen
            }

            // Manejar la actualización de asfi_imagen
            if ($request->file('asfi_imagen')) {
                $asfiImagen = $request->file('asfi_imagen');
                $nombreAsfiImagen = time() . '.' . $asfiImagen->getClientOriginalExtension(); // Usar la extensión original
                $asfiImagen->move("images/empresa/", $nombreAsfiImagen);
                $empresa->asfi_imagen = $nombreAsfiImagen; // Asignar la nueva imagen
            }

            // Manejar la actualización del logo
            if ($request->file('logo')) {
                $logo = $request->file('logo');
                $nombreLogo = time() . '.' . $logo->getClientOriginalExtension(); // Usar la extensión original
                $logo->move("images/empresa/", $nombreLogo);
                $empresa->logo = $nombreLogo; // Asignar la nueva imagen
            }

            // Actualizar otros campos
            $empresa->mision = $request->mision;
            $empresa->vision = $request->vision;
            $empresa->historia = nl2br($request->historia); // Convierte saltos de línea a <br>
            $empresa->aspecto_legal = $request->aspecto_legal;
            $empresa->direccion = $request->direccion;
            $empresa->celular = $request->celular;
            $empresa->email = $request->email;
            $empresa->latitud = $request->latitud;
            $empresa->longitud = $request->longitud;
            $empresa->save();

            return response()->json($empresa, 200); // Retorna la empresa actualizada
        } catch (\Throwable $e) {
            return response()->json("existe un error: " . $e->getMessage(), 500);
        }
    }
}
