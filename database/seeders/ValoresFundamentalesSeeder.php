<?php

namespace Database\Seeders;

use App\Models\ValoresFundamentales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValoresFundamentalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ValoresFundamentales::create([
            'titulo' => 'COMPROMISO SOCIAL:',
            'descripcion' => 'COMPROMETIDOS CON LA SENSIBILIDAD SOCIAL, EL DESARROLLO Y CRECIMIENTO DE LA COOPERATIVA Y EL BIEN COMÚN.',
        ]);
        ValoresFundamentales::create([
            'titulo' => 'VOCACIÓN DE SERVICIO:',
            'descripcion' => ' BRINDAMOS ATENCIÓN DE CALIDAD A LOS CLIENTES, OFRECIENDO NUESTROS PRODUCTOS Y SERVICIOS DE FORMA ACCESIBLE.',
        ]);
        ValoresFundamentales::create([
            'titulo' => 'CALIDAD:',
            'descripcion' => 'LA EXCELENCIA ES NUESTRA PRIORIDAD, GARANTIZAMOS LA MEJORA CONTINUA DE LOS PRODUCTOS Y SERVICIOS FINANCIEROS PARA LOS SOCIOS Y CLIENTES.',
        ]);
        ValoresFundamentales::create([
            'titulo' => 'INTEGRIDAD:',
            'descripcion' => 'ACTUAMOS CON ÉTICA PROFESIONAL Y TRANSPARENCIA EN EL CUMPLIMIENTO DE LOS OBJETIVOS Y LA NORMATIVA VIGENTE, SOMOS CONSECUENTES, SE HACE LO QUE SE DICE.',
        ]);
        ValoresFundamentales::create([
            'titulo' => 'RESPONSABILIDAD:',
            'descripcion' => 'CUMPLIMOS CON NUESTRAS OBLIGACIONES Y MISIÓN INSTITUCIONAL, ACTUAMOS CON EMPATÍA, CALIDAD, Y CALIDEZ.',
        ]);
    }
}
