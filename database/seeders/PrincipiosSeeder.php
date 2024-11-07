<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrincipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('principios')->insert([
            [
                'nro_de_principio' => 'Primer Principio:',
                'titulo' => 'Membrecía abierta y voluntaria',
                'descripcion' => 'Las cooperativas son organizaciones voluntarias abiertas para todas aquellas personas dispuestas a utilizar sus servicios y dispuestas a aceptar las responsabilidades que conlleva la membrecía sin discriminación de género, raza, clase social, posición política o religiosa.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Segundo Principio:',
                'titulo' => 'Control democrático de los miembros',
                'descripcion' => 'Las cooperativas son organizaciones democráticas controladas por sus miembros quienes participan activamente en la definición de las políticas y en la toma de decisiones. Los hombres y mujeres elegidos para representar a su cooperativa, responden ante los miembros. En las cooperativas de base los miembros tienen igual derecho de voto (un miembro, un voto), mientras en las cooperativas de otros niveles también se organizan con procedimientos democráticos.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Tercer Principio:',
                'titulo' => 'Participación económica de los miembros',
                'descripcion' => 'Las cooperativas son organizaciones autónomas de ayuda mutua, controladas por sus miembros. Si entran en acuerdos con otras organizaciones (incluyendo gobiernos) o tienen capital de fuentes externas, lo realizan en términos que aseguren el control democrático por parte de sus miembros y mantengan la autonomía de la cooperativa.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Cuarto Principio:',
                'titulo' => 'Autonomía e independencia',
                'descripcion' => 'Las cooperativas son organizaciones autónomas de ayuda mutua, controladas por sus miembros. Si entran en acuerdos con otras organizaciones (incluyendo gobiernos) o tienen capital de fuentes externas, lo realizan en términos que aseguren el control democrático por parte de sus miembros y mantengan la autonomía de la cooperativa.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Quinto Principio:',
                'titulo' => 'Educación, formación e información',
                'descripcion' => 'Las cooperativas brindan educación y entrenamiento a sus miembros, a sus dirigentes electos, gerentes y empleados, de tal forma que contribuyan eficazmente al desarrollo de sus cooperativas. Las cooperativas informan al público en general, particularmente a jóvenes y
creadores de opinión, acerca de la naturaleza y beneficios del cooperativismo.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Sexto Principio:',
                'titulo' => 'Principio de Equidad',
                'descripcion' => 'Las cooperativas sirven a sus miembros más eficazmente y fortalecen el movimiento cooperativo trabajando de manera conjunta por medio de estructuras locales, nacionales, regionales e internacionales.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_de_principio' => 'Séptimo Principio:',
                'titulo' => 'Compromiso con la comunidad',
                'descripcion' => 'La cooperativa trabaja para el desarrollo sostenible de su comunidad por medio de políticas aceptadas por sus miembros.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más principios según sea necesario
        ]);
    }
}
