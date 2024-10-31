<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Crear el rol de super_admin si no existe
    $role = Role::firstOrCreate(['name' => 'super_admin']);

    // Verificar si el usuario ya existe
    $user = User::where('email', 'cooperativaloyola2024@mail.com')->first();

    if (!$user) {
        // Crear un nuevo usuario
        $user = User::create([
            'nombre' => 'Admin', // Cambia esto según sea necesario
            'apellido' => 'User', // Cambia esto según sea necesario
            'email' => 'cooperativaloyola2024@mail.com', // Cambia esto según sea necesario
            'password' => bcrypt('password'), // Cambia esto según sea necesario
            'is_active' => true,
        ]);
        // Asignar el rol al usuario
        $user->assignRole($role);
    }
}
}
