<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoSerSocio extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo', 'subtitulo',
    ];
}
