<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrincipiosTextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('principios_texts')->insert([
            [
                'principios_fundamentales' => 'Son elementos distintivos de las organizaciones y empresas cooperativas que demostraron ser eficientes en casi 170 años de historia y contribuyen a transformar al cooperativismo en una de las mayores fuerzas sociales y económicas a nivel mundial.',
                'principios_cooperativos' => 'Consolidarse como una de las primeras cooperativas de Cochabamba, con suficiente capacidad humana, financiera y tecnológica, contribuyendo al beneficio económico y bienestar de nuestros socios y clientes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
