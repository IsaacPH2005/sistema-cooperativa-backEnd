<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caracteristicas_creditos extends Model
{
    use HasFactory;
     // Agrega el campo credito_id aquí
     protected $fillable = [
        'credito_id',
        'caracteristicas', // Asegúrate de que también esté este campo si lo necesitas
    ];
    public function credito()
    {
        return $this->belongsTo(creditos::class, 'credito_id'); // Use the foreign key here
    } 
}
