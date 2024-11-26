<?php

namespace Database\Seeders;

use App\Models\OpcionesDeSerSocios;
use App\Models\RequirimientosDeSerSocios;
use Illuminate\Database\Seeder;

class OpcionesDeSerSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opción 1
        $opcion1 = OpcionesDeSerSocios::create([
            'id' => 1,
            'titulo' => 'Opcion 1',
            'descripcion' => 'Presentar en Secretaría de la Cooperativa Loyola, para que sea evaluada en el Consejo de Administración de la Cooperativa, los siguientes documentos:',
        ]);

        // Requerimientos para Opción 1
        $requerimientos1 = [
            [
                'ser_socio_id' => $opcion1->id,
                'requerimientos' => 'El certificado de asistencia al “Curso de Cooperativismo, Gobernabilidad y Voluntariado”, que se realiza dos veces por año en las instalaciones de la Cooperativa y que se dan a conocer por nuestra página web y redes sociales.'
            ],
            [
                'ser_socio_id' => $opcion1->id,
                'requerimientos' => 'Y una carta de solicitud de incorporación como socio en la Cooperativa.'
            ],
            // Agrega más requerimientos aquí
        ];

        foreach ($requerimientos1 as $requerimiento) {
            RequirimientosDeSerSocios::create($requerimiento);
        }

        OpcionesDeSerSocios::create([
            'id' => 2,
            'titulo' => 'Opcion 2',
            'descripcion' => 'A momento de solicitar un préstamo en la Cooperativa, que una vez aprobado, debe comprar certificados de aportación.',
        ]);
    }
}