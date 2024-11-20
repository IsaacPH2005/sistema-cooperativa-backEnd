<?php

namespace Database\Seeders;

use App\Models\TablaDpfs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TablaDpfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TablaDpfs::create([
            'plazo' => 30,
            'interes_bs' => 0.015,
            'interes_usd' => 0.005,
        ]);
        TablaDpfs::create([
            'plazo' => 60,
            'interes_bs' => 0.0175,
            'interes_usd' => 0.005,
        ]);
        TablaDpfs::create([
            'plazo' => 90,
            'interes_bs' => 0.025,
            'interes_usd' => 0.005,
        ]);
        TablaDpfs::create([
            'plazo' => 180,
            'interes_bs' => 0.045,
            'interes_usd' => 0.0075,
        ]);
        TablaDpfs::create([
            'plazo' => 360,
            'interes_bs' => 0.0475,
            'interes_usd' => 0.01,
        ]);
        TablaDpfs::create([
            'plazo' => 390,
            'interes_bs' => 0.055,
            'interes_usd' => 0.0125,
        ]);
        TablaDpfs::create([
            'plazo' => 540,
            'interes_bs' => 0.06,
            'interes_usd' => 0.015,
        ]);
        TablaDpfs::create([
            'plazo' => 720,
            'interes_bs' => 0.0625,
            'interes_usd' => 0.0175,
        ]);
        TablaDpfs::create([
            'plazo' => 1080,
            'interes_bs' => 0.065,
            'interes_usd' => 0.02,
        ]);
        TablaDpfs::create([
            'plazo' => 1440,
            'interes_bs' => 0.07,
            'interes_usd' => 0.0225,
        ]);
        TablaDpfs::create([
            'plazo' => 1800,
            'interes_bs' => 0.0725,
            'interes_usd' => 0.025,
        ]);
    }
}
