<?php

namespace Database\Seeders;

use App\Models\DpfCardWeb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DpfWebCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DpfCardWeb::create([
            'titulo' => 'DEPÓSITO A PLAZO FIJO',
            'descripcion' => 'Asegura tus ahorros a una tasa de interés garantizada por un período de tiempo.',
            'imagen' => '',
        ]);
    }
}
