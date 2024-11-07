<?php

namespace Database\Seeders;

use App\Models\PuntoDeReclamo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuntoDeReclamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear varios registros en la tabla punto_de_reclamos
         PuntoDeReclamo::create([
            'fecha_del_hecho' => '2023-10-01',
            'categoria' => 'Servicio',
            'sub_categoria' => 'Reclamo de Factura',
            'monto_comprometido' => '100.00',
            'opciones_multiples_1' => 'Opción 1',
            'agencia' => 'Agencia 1',
            'descripcion' => 'Descripción del reclamo 1',
            'tipo_persona' => 'Natural',
            'representante_legal' => null,
            'numero_de_testimonio' => '123456',
            'nombre_o_razon_social' => 'Juan Pérez',
            'numero_de_documento' => '12345678',
            'opciones_multiples_2' => 'Opción A',
            'complemento' => 'Complemento 1',
            'expedido_en' => 'Ciudad 1',
            'celular' => '987654321',
            'correo_electronico' => 'juan.perez@example.com',
            'direccion' => 'Calle 1, Ciudad 1',
            'medio_de_envio_de_respuesta' => 'Correo Electrónico',
            'telefono_fijo' => '123456789',
            'recibir_numero_de_reclamo' => 'Sí',
        ]);

        PuntoDeReclamo::create([
            'fecha_del_hecho' => '2023-10-02',
            'categoria' => 'Producto',
            'sub_categoria' => 'Devolución',
            'monto_comprometido' => '50.00',
            'opciones_multiples_1' => 'Opción 2',
            'agencia' => 'Agencia 2',
            'descripcion' => 'Descripción del reclamo 2',
            'tipo_persona' => 'Jurídica',
            'representante_legal' => 'Pedro Gómez',
            'numero_de_testimonio' => '654321',
            'nombre_o_razon_social' => 'Empresa XYZ',
            'numero_de_documento' => '87654321',
            'opciones_multiples_2' => 'Opción B',
            'complemento' => 'Complemento 2',
            'expedido_en' => 'Ciudad 2',
            'celular' => '987654322',
            'correo_electronico' => 'contacto@empresa.xyz',
            'direccion' => 'Calle 2, Ciudad 2',
            'medio_de_envio_de_respuesta' => 'Teléfono',
            'telefono_fijo' => '987654321',
            'recibir_numero_de_reclamo' => 'No',
        ]);
    }
}
