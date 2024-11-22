<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebRedesSocialesCoop extends Model
{
    use HasFactory;
    protected $table = 'web_redes_sociales_coops'; // Asegúrate de que este nombre coincida con la tabla creada

    protected $fillable = [
        'nombre',
        'logo',
        'url',
        'estado',
    ];
}
