<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideosEducacionFinancieras extends Model
{
    use HasFactory;
    protected $fillable = [
        'video', // Agrega el campo video al fillable property
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); // Asegúrate de que 'created_by' sea el nombre de la columna en la base de datos
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by'); // Asegúrate de que 'updated_by' sea el nombre de la columna en la base de datos
    }
}
