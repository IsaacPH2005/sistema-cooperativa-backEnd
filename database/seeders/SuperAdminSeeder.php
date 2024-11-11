<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles si no existen
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Super Administrador']);
        $roleUsuario = Role::firstOrCreate(['name' => 'usuario']);

        // Definir los usuarios a crear
        $users = [
            [
                'nombre' => 'Admin',
                'apellido' => 'User ',
                'email' => 'user1@mail.com',
                'password' => 'user1',
                'role' => $roleSuperAdmin,
                'is_active' => 0,
            ],
            [
                'nombre' => 'Usuario 1',
                'apellido' => 'Apellido',
                'email' => 'usuario1@mail.com',
                'password' => 'user2',
                'role' => $roleUsuario,
                'is_active' => 0,
            ],
            [
                'nombre' => 'Usuario 2',
                'apellido' => 'Apellido',
                'email' => 'usuario2@mail.com',
                'password' => 'user2',
                'role' => $roleUsuario,
                'is_active' => 0,
            ],
            [
                'nombre' => 'Usuario 3',
                'apellido' => 'Apellido',
                'email' => 'usuario3@mail.com',
                'password' => 'user3',
                'role' => $roleUsuario,
                'is_active' => 0,
            ],
            [
                'nombre' => 'Usuario 4',
                'apellido' => 'Apellido',
                'email' => 'usuario4@mail.com',
                'password' => 'user4',
                'role' => $roleUsuario,
                'is_active' => 0,
            ],
        ];

        // Crear usuarios y asignar roles
        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'nombre' => $userData['nombre'],
                    'apellido' => $userData['apellido'],
                    'password' => bcrypt($userData['password']),
                    'is_active' => $userData['is_active'],
                ]
            );

            // Asignar el rol al usuario
            $user->assignRole($userData['role']);
        }
    }
}