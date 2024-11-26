<?php

namespace Database\Seeders;

use App\Models\vigilancias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalVigilanciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        vigilancias::create([
            'nombre' => 'Ing. Edgar Diego',
            'apellido' => 'Delgado Ortega',
            'cargo' => 'Presidente',
        ]);
        vigilancias::create([
            'nombre' => 'Cdra. Aydee',
            'apellido' => 'Muñoz Vda. de Añez',
            'cargo' => 'Secretaria',
        ]);
        vigilancias::create([
            'nombre' => 'Virginia Antonieta',
            'apellido' => 'Rojas Moya',
            'cargo' => 'Vocal',
        ]);
    }
}
