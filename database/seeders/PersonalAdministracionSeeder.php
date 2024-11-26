<?php

namespace Database\Seeders;

use App\Models\administraciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalAdministracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        administraciones::create([
            'nombre' => 'Lic. Janet',
            'apellido' => 'Villanueva Tapia de Arispe',
            'cargo' => 'Presidente',
        ]);
        administraciones::create([
            'nombre' => 'Liliam ',
            'apellido' => 'Zamorano',
            'cargo' => 'Vice Presidente',
        ]);
        administraciones::create([
            'nombre' => 'Carlos Alberto',
            'apellido' => 'Enriquez Soliz',
            'cargo' => 'Secretario',
        ]);
        administraciones::create([
            'nombre' => 'Cecilia Fabiola',
            'apellido' => 'Ugarte Rivero',
            'cargo' => 'Tesorera',
        ]);
        administraciones::create([
            'nombre' => 'Joelma',
            'apellido' => 'Lopez Peñarrieta',
            'cargo' => 'Vocal',
        ]);
        administraciones::create([
            'nombre' => 'Prof. Julieta',
            'apellido' => 'Motaño Vidal',
            'cargo' => 'Vocal Suplente',
        ]);
    }
}
