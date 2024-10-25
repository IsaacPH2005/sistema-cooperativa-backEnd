<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes_Inmuebles extends Model
{
    use HasFactory;
    public function bienesInmueble()
    {
        return $this->belongsTo(bienes_inmuebles::class, 'bienes_inmueble_id'); // Use the foreign key here
    }
}
