<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agencias extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'imagen', 'calle', 'telefono', 'url_mapa'];

    public function horarios()
    {
        return $this->hasMany(horarios::class, 'agencia_id'); // Use the foreign key here
    } 
}
