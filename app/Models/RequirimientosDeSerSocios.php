<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirimientosDeSerSocios extends Model
{
    use HasFactory;
    // Agrega el campo credito_id aquí
    protected $fillable = [
        'ser_socio_id', // Asegúrate de que este campo esté aquí
        'requerimientos',  // Agrega otros campos necesarios
    ];
    public function opcionDeSerSocio()
    {
        return $this->belongsTo(OpcionesDeSerSocios::class, 'ser_socio_id'); // Especificando el foreign key
    }
}
