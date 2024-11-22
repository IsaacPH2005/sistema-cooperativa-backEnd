<?php

namespace Database\Seeders;

use App\Models\InformacionImportante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformacionImportanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InformacionImportante::create([
            'imagen_1' => null,
            'imagen_2' => null,
        ]);
    }
}
