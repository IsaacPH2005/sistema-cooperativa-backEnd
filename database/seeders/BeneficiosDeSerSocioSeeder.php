<?php

namespace Database\Seeders;

use App\Models\BeneficiosDeSerSocios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiosDeSerSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeneficiosDeSerSocios::create([
            'beneficio' => 'Practicar los principios de solidaridad, cooperación y crecimiento.'
        ]);
        BeneficiosDeSerSocios::create([
            'beneficio' => 'Contar con créditos de forma fácil y con principios cooperativistas.'
        ]);
        BeneficiosDeSerSocios::create([
            'beneficio' => 'Tener un regalo de víveres una vez al año por asistir a asambleas.'
        ]);
        BeneficiosDeSerSocios::create([
            'beneficio' => 'Recibir capacitaciones de calidad en universidades o escuelas de negocio.'
        ]);
        BeneficiosDeSerSocios::create([
            'beneficio' => 'Ahorra sistemáticamente en las cajas de ahorro o PDF, con los intereses más altos del sistema financiero nacional.'
        ]);
    }
}
