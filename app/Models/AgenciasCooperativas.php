<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciasCooperativas extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'imagen', 'calle', 'telefono', 'url_mapa'];

    public function horarios()
    {
        return $this->hasMany(HorariosAgencias::class, 'agencias_cooperativas_id'); // Use the foreign key here
    } 
}
