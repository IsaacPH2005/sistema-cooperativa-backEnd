<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisitos_creditos extends Model
{
    use HasFactory;
      // Agrega el campo credito_id aquí
      protected $fillable = [
        'credito_id', // Asegúrate de que este campo esté aquí
        'requisitos',  // Agrega otros campos necesarios
    ];
    public function credito()
    {
        return $this->belongsTo(creditos::class, 'credito_id'); // Especificando el foreign key
    }
}
