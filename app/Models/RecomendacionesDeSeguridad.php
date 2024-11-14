<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendacionesDeSeguridad extends Model
{
    use HasFactory;
          // Agrega el campo credito_id aquí
          protected $fillable = [
            'seguridad_id', // Asegúrate de que este campo esté aquí
            'recomendacion',  // Agrega otros campos necesarios
        ];
        public function recomendacion()
        {
            return $this->belongsTo(SeguridadTips::class, 'seguridad_id'); // Especificando el foreign key
        }
}
