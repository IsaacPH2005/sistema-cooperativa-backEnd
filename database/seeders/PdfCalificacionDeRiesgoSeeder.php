<?php

namespace Database\Seeders;

use App\Models\PdfCalificacionDeRiesgos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PdfCalificacionDeRiesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PdfCalificacionDeRiesgos::create([
            'pdf' => null
        ]);
    }
}
