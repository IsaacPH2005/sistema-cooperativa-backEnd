<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaginasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paginas')->insert([
            'nombre' => 'DPF',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Historia',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Misión, Visión y Valores',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Principios',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Himno',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Institucional',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Servicios Básicos y Otros',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Transferencias Electrónicas',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Remates y Bienes Adjudicados',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Consejos de Administración y Vigilancia',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Memoria Institucional',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Estados Financieros',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Calificación de Riesgo',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'COEFICIENTE DE ADECUACIÓN PATRIMONIAL',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Dictámenes Auditoria',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Educación Financiera',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Recomendaciones de Seguridad',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Punto de Reclamo',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Licitación Pública',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Responsabilidad Social',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Contactanos',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'agencias',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Cooperativa de Ahorro y Crédito',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Cuenta de ahorro',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Punto de reclamo',
        ]);
        DB::table('paginas')->insert([
            'nombre' => 'Quiero ser socio',
        ]);
    }
}
