<?php

namespace Database\Seeders;

use App\Models\CooperativaInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CooperativaInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CooperativaInfo::create([
            'titulo' => '¿Qué es una Cooperativa de ahorro y crédito?',
            'descripcion' => 'Una Cooperativa de ahorro y crédito es una organización sin fines de lucro fundada para servir de forma exclusiva a sus socios promoviendo su bienestar a través de productos y servicios financieros. Por su esencia, las Cooperativas no tienen clientes sino socios, los cuales valoran participar en una institución diseñada para ayudar a otros socios y a la comunidad.

A diferencia de un banco, que pertenece a un grupo de accionistas, las Cooperativas trabajan por y para sus socios, los cuales también son propietarios de la institución y reciben los beneficios de ésta en forma de distribución de remanentes y mejores productos financieros con tasas de interés altamente competitivas.

Por estas razones, pertenecer a una Cooperativa, significa ser un miembro activo de una comunidad que crece continuamente.',
            'imagen' => '',
        ]);
    }
}
