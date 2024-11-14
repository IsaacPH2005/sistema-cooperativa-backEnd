<?php

namespace Database\Seeders;

use App\Models\InfoSerSocio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSerSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InfoSerSocio::create([
            'titulo' => '¿Qué necesito para ser socio?',
            'sub_titulo' => 'Para ser socio de la Cooperativa LOYOLA, de acuerdo a nuestro estatuto, existen dos caminos:',
        ]);
    }
}
