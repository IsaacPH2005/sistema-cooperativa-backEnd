<?php

namespace Database\Seeders;

use App\Models\TasasYTarifas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasasTarifasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TasasYTarifas::create([
            'pdf' => null,
        ]);
    }
}
