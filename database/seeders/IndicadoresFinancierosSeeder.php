<?php

namespace Database\Seeders;

use App\Models\IndicadoresFinancieros;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicadoresFinancierosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndicadoresFinancieros::create([
            'nombre' => 'TRe ME',
            'valor' => '1,28 %',
        ]);
        IndicadoresFinancieros::create([
            'nombre' => 'TRa MN',
            'valor' => '2,87%',
        ]);
        IndicadoresFinancieros::create([
            'nombre' => 'TRe MV',
            'valor' => '0,00 %',
        ]);
        IndicadoresFinancieros::create([
            'nombre' => 'TRe UFV:',
            'valor' => '0,01 %',
        ]);
        IndicadoresFinancieros::create([
            'nombre' => 'Dolar Compra',
            'valor' => '6.86 Bs',
        ]);
        IndicadoresFinancieros::create([
            'nombre' => 'Dolar Venta',
            'valor' => '6.96 Bs',
        ]);
        
    }
}
