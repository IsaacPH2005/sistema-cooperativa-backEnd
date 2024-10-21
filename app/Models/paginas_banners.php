<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paginas_banners extends Model
{
    use HasFactory;
    public function paginas()
    {
        return $this->belongsTo(paginas::class, 'pagina_id');
    }
}
