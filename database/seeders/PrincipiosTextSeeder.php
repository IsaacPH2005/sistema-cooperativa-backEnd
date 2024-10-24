<?php

namespace Database\Seeders;

use App\Models\principios_text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrincipiosTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        principios_text::create([
            'principios_fundamentales' => 'Son elementos distintivos de las organizaciones y empresas cooperativas que demostraron ser eficientes en casi 170 años de historia y contribuyen a transformar al cooperativismo en una de las mayores fuerzas sociales y económicas a nivel mundial.',
            'principios_cooperativos' => 'Consolidarse como una de las primeras cooperativas de Cochabamba, con suficiente capacidad humana, financiera y tecnológica, contribuyendo al beneficio económico y bienestar de nuestros socios y clientes.',
        ]);
    }
}
