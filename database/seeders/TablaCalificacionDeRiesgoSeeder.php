<?php

namespace Database\Seeders;

use App\Models\TablaCalificacionDeRiesgos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TablaCalificacionDeRiesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TablaCalificacionDeRiesgos::create([
            "celda_1" => 'BBB',
            "celda_2" => 'BBB2',
            "celda_3" => 'BBB',
            "celda_4" => 'BBB2',
            "celda_5" => 'BBB',
            "celda_6" => 'BBB2',
            "celda_7" => 'F3',
            "celda_8" => 'N-3',
            "celda_9" => 'F3',
            "celda_10" => 'N-3',
            "fecha" => null,
        ]);
    }
}
