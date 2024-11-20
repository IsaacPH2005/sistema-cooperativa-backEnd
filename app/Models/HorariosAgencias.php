<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosAgencias extends Model
{
    use HasFactory;
    protected $fillable = ['agencias_cooperativas_id', 'dias', 'horas'];

    public function horarios()
    {
        return $this->belongsTo(AgenciasCooperativas::class, 'agencias_cooperativas_id'); // Especificando el foreign key
    }
}
