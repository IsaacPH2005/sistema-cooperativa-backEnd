<?php

namespace Database\Seeders;

use App\Models\ImagenValoresFundamentales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagenValoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImagenValoresFundamentales::create([
            'nombre_de_la_imagen' => 'Imagen que representa los valores fundamentales de la cooperativa',
            'imagen' => null,
        ]);
    }
}
