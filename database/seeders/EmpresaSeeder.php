<?php

namespace Database\Seeders;

use App\Models\empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        empresa::create([
            'historia' => 'La Cooperativa de Ahorro y Crédito Abierta “Loyola” R.L., fue fundada por el Rdo. Padre Jaime Nadal Guiu S.J. el 28 de noviembre de 1964.

Inicialmente el objetivo fue el de apoyar por intermedio de sus socios a los estudiantes de escasos recursos, para ello se planificaron acciones como “Operación Guaga” para ayuda y lograr el bienestar social, en el cual se beneficiaron a 171 niños. Posteriormente las actividades empresariales han estado orientadas a beneficiar a sus socios de base, para lograr mayor impacto, con seminarios y asambleas para dar a conocer los planes, programas y proyectos de expansión.

Además de formar nuevos líderes entre sus mismos socios quienes se encargan de difundir la calidad del servicio de la Cooperativa.

',
            "mision" => '"BRINDAMOS SERVICIOS Y PRODUCTOS FINANCIEROS INCLUYENTES, CONEXOS O COMPLEMENTARIOS PARA FOMENTAR ACTIVIDADES ECONÓMICAS Y PRODUCTIVAS, HACIA LOS SOCIOS Y CLIENTES, CON RECURSOS HUMANOS CALIFICADOS, MEDIOS TECNOLÓGICOS Y UNA EFICIENTE GESTIÓN DE RIESGOS"',
            "vision" => '"SER UNA COOPERATIVA LÍDER EN EL MERCADO FINANCIERO, QUE PROMUEVE EL DESARROLLO DE LA REGIÓN, CON UN CAPITAL HUMANO COMPROMETIDO CON LA EXCELENCIA EN EL SERVICIO, CALIDAD, AMIGABLE CON EL MEDIO AMBIENTE Y LA CREACIÓN DE VALOR ECONÓMICO PARA NUESTROS SOCIOS A LOS QUE SERVIMOS"',
            "aspecto_legal" => 'Es una de las primeras Cooperativas que ingresa al proceso de adecuación estipulada en la Ley de Bancos, cumpliendo con las disposiciones legales, obteniendo el 23 de febrero del año 2000 la licencia de funcionamiento de la Superintendencia de Bancos y Entidades Financieras (hoy ASFI).',
            "imagen" => 'https://www.cooperativaloyola.com/wp-content/uploads/2022/08/institucional-portada.jpg',
            "asfi_imagen" => 'https://cooperativaloyola.com/wp-content/uploads/2020/01/logo-asfi.png',
            "logo" => 'https://cooperativaloyola.com/wp-content/uploads/2020/04/marca-loyola.png',
        ]);
    }
}
 