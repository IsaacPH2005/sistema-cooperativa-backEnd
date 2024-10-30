<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class creditos extends Model
{
    use HasFactory;
    public function caracteristicas()
    {
        return $this->hasMany(caracteristicas_creditos::class, 'credito_id'); // Use the foreign key here
    } 
    public function requisitos()
    {
        return $this->hasMany(requisitos_creditos::class, 'credito_id'); // Use the foreign key here
    } 
}
