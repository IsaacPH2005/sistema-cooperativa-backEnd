<?php

namespace Database\Seeders;

use App\Models\CaracteristicasCuentaDeAhorro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaracteristicasCuentaDeAhorroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CaracteristicasCuentaDeAhorro::create([
            'descripcion' => 'Es un producto ofertado por la Cooperativa Loyola para que el cliente pueda realizar depósitos y retiros de dinero en una cuenta específica, bajo las condiciones estipuladas en el contrato y la normativa del país.',
        ]);
    }
}
