<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguridadTips extends Model
{
    use HasFactory;
    public function recomendaciones()
    {
        return $this->hasMany(RecomendacionesDeSeguridad::class, 'seguridad_id'); // Use the foreign key here
    } 
}
