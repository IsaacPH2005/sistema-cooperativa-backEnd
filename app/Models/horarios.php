<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horarios extends Model
{
    use HasFactory;
    protected $fillable = ['agencia_id', 'dias', 'horas'];

    public function agencia()
    {
        return $this->belongsTo(agencias::class, 'agencia_id'); // Especificando el foreign key
    }
}
