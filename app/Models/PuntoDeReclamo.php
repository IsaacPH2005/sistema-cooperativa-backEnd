<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoDeReclamo extends Model
{
    use HasFactory;
    // Agrega aquí los campos que deseas permitir para la asignación masiva
    protected $fillable = [
        'fecha_del_hecho',
        'categoria',
        'sub_categoria',
        'monto_comprometido',
        'opciones_multiples_1',
        'agencia',
        'descripcion',
        'tipo_persona',
        'representante_legal',
        'numero_de_documento',
        'numero_de_testimonio',
        'nombre_o_razon_social',
        'opciones_multiples_2',
        'complemento',
        'expedido_en',
        'celular',
        'correo_electronico',
        'direccion',
        'medio_de_envio_de_respuesta',
        'telefono_fijo',
        'recibir_numero_de_reclamo',
    ];
}
