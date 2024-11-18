<?php

namespace Database\Seeders;

use App\Models\CodigoDeEtica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CodigoEticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CodigoDeEtica::create([
            'pdf' => null,
        ]);
    }
}
