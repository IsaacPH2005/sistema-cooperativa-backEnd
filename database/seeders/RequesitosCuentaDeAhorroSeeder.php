<?php

namespace Database\Seeders;

use App\Models\RequisitosCuentaDeAhorro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequesitosCuentaDeAhorroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RequisitosCuentaDeAhorro::create([
            'descripcion' => 'Carnet de Identidad del interesado.'
        ]);
        RequisitosCuentaDeAhorro::create([
            'descripcion' => 'Monto mínimo de apertura cuenta Bolivianos Bs. 10,-'
        ]);
        RequisitosCuentaDeAhorro::create([
            'descripcion' => 'Monto mínimo de apertura cuenta Bolivianos Bs. 10,-'
        ]);
    }
}
