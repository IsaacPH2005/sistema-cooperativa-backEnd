<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionesDeSerSocios extends Model
{
    use HasFactory;
    public function requerimientos()
    {
        return $this->hasMany(RequirimientosDeSerSocios::class, 'ser_socio_id'); // Use the foreign key here
    } 
}
