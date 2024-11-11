<?php

namespace Database\Seeders;

use App\Models\CuentaDeAhorro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentaDeAhorroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CuentaDeAhorro::create([
            'titulo' => 'CUENTA DE AHORRO',
            'descripcion' => 'Obtén una tasa de interés atractiva y acceso a tu dinero cuando lo necesites.',
            'imagen' => '',
        ]);
    }
}
