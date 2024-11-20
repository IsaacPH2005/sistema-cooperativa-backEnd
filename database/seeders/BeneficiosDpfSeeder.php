<?php

namespace Database\Seeders;

use App\Models\BeneficiosDpf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiosDpfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BeneficiosDpf::create([
            'titulo' => 'Es seguro:',
            'descripcion' => 'Prácticamente no hay peligro ni riesgo. Sin duda, hacer un depósito a plazo es mejor que guardar el dinero en casa donde está sujeto al riesgo de robos, incendios o tentaciones al gasto. Pero debe asegurarse que la entidad que escoja esté supervisada por la Superintendencia de Banca, Seguros y AFP y sea miembro del Fondo de Seguros de Depósito.',
        ]);
        BeneficiosDpf::create([
            'titulo' => 'Es rentable:',
            'descripcion' => 'El depósito a plazo le da una rentabilidad fija superior al de una cuenta de ahorros, es decir, la tasa de interés no se modifica hasta la fecha de vencimiento.',
        ]);
        BeneficiosDpf::create([
            'titulo' => 'Es fácil:',
            'descripcion' => 'Abrir un depósito a plazo es muy sencillo, solo tiene que acercarse con su CI a la entidad financiera de su preferencia, evaluar la TRe del producto (tasa de interés), definir el plazo y finalmente depositar su dinero. Si el dinero lo tiene en otra entidad financiera, no tiene que retirarlo y llevarlo en efectivo, puede utilizar una transferencia interbancaria o solicitar un cheque de gerencia lo que te permitirá de forma segura movilizar su dinero.',
        ]);
    }
}
