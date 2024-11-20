<?php

namespace Database\Seeders;

use App\Models\RequisitosDpf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequisitosDpfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RequisitosDpf::create([
            'descripcion' => 'A sola presentación de carnet de identidad.',
        ]);
    }
}
