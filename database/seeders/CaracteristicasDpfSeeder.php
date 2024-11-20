<?php

namespace Database\Seeders;

use App\Models\CaracteristicasDpf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaracteristicasDpfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CaracteristicasDpf::create([
            'titulo' => '¿QUÉ ES UN DPF?',
            'descripcion' => 'Un DPF (Depósito a Plazo Fijo) es un producto financiero de ahorro que ofrece la “Cooperativa Loyola R.L.” y que consiste en la entrega o depósito de una cantidad de dinero a la entidad bajo la modalidad de plazo específico; generando intereses muy atractivos durante este periodo que pueden ser cancelados periódicamente o al vencimiento, a decisión del cliente.',
        ]);
    }
}
