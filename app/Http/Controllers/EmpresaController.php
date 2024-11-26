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
            if ($empresa->img_vision) {
                $empresa->img_vision = asset('images/empresa/' . $empresa->img_vision);
            }
            if ($empresa->img_mision) {
                $empresa->img_mision = asset('images/empresa/' . $empresa->img_mision);
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
            if ($empresa->img_vision) {
                $empresa->img_vision = asset('images/empresa/' . $empresa->img_vision);
            }
            if ($empresa->img_mision) {
                $empresa->img_mision = asset('images/empresa/' . $empresa->img_mision);
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
                "imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
                "asfi_imagen" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
                "logo" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
                "img_vision" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
                "img_mision" => 'nullable|mimes:jpg,png,jpeg,gif,svg.webp|max:20480',
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
                $nombreImagen = md5_file($imagen->getPathname()) . '.' . $imagen->getClientOriginalExtension();
                $imagen->move("images/empresa/", $nombreImagen);
                $empresa->imagen = $nombreImagen; // Asignar la nueva imagen
            }

            // Manejar la actualización de asfi_imagen
            if ($request->file('asfi_imagen')) {
                $asfiImagen = $request->file('asfi_imagen');
                $nombreAsfiImagen = md5_file($asfiImagen->getPathname()) . '.' . $asfiImagen->getClientOriginalExtension();
                $asfiImagen->move("images/empresa/", $nombreAsfiImagen);
                $empresa->asfi_imagen = $nombreAsfiImagen; // Asignar la nueva imagen
            }

            // Manejar la actualización del logo
            if ($request->file('logo')) {
                $logo = $request->file('logo');
                $nombreLogo = md5_file($logo->getPathname()) . '.' . $logo->getClientOriginalExtension();
                $logo->move("images/empresa/", $nombreLogo);
                $empresa->logo = $nombreLogo; // Asignar la nueva imagen
            }
              // Manejar la actualización del logo
              if ($request->file('img_vision')) {
                $img_vision = $request->file('img_vision');
                $nombreimg_vision = md5_file($img_vision->getPathname()) . '.' . $img_vision->getClientOriginalExtension();
                $img_vision->move("images/empresa/", $nombreimg_vision);
                $empresa->img_vision = $nombreimg_vision; // Asignar la nueva imagen
            }
              // Manejar la actualización del logo
              if ($request->file('img_mision')) {
                $img_mision = $request->file('img_mision');
                $nombreimg_mision = md5_file($img_mision->getPathname()) . '.' . $img_mision->getClientOriginalExtension();
                $img_mision->move("images/empresa/", $nombreimg_mision);
                $empresa->img_mision = $nombreimg_mision; // Asignar la nueva imagen
            }

            // Actualizar otros campos
            $empresa->mision = $request->mision;
            $empresa->vision = $request->vision;
            $empresa->historia = nl2br($request->historia); // Convierte saltos de línea a <br>
            $empresa->aspecto_legal = $request->aspecto_legal;
            $empresa->direccion = $request->direccion;
            $empresa->celular = $request->celular;
            $empresa->telefono = $request->telefono;
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
