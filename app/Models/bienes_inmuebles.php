<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bienes_inmuebles extends Model
{
    use HasFactory;
    public function imagenes()
    {
        return $this->hasMany(Imagenes_Inmuebles::class, 'bienes_inmueble_id'); // Use the foreign key here
    } 
}
