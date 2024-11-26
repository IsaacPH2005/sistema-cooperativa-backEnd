<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(class: [PaginasSeeder::class]);
        $this->call(class: [EmpresaSeeder::class]);
        $this->call(class: [PrincipiosTextSeeder::class]);
        $this->call(class: [SuperAdminSeeder::class]);
        $this->call(class: [PuntoDeReclamoSeeder::class]);
        $this->call(class: [IndicadoresFinancierosSeeder::class]);
        $this->call(class: [PrincipiosSeeder::class]);   
        $this->call(class: [PrincipiosTextsSeeder::class]);
        $this->call(class: [CuentaDeAhorroSeeder::class]);
        $this->call(class: [InfoSerSocioSeeder::class]);
        $this->call(class: [DpfWebCardSeeder::class]);
        $this->call(class: [CooperativaInfoSeeder::class]);
        $this->call(class: [TasasTarifasSeeder::class]);
        $this->call(class: [CodigoEticaSeeder::class]);
        $this->call(class: [PdfCalificacionDeRiesgoSeeder::class]);
        $this->call(class: [TablaCalificacionDeRiesgoSeeder::class]);
        $this->call(class: [CaracteristicasCuentaDeAhorroSeeder::class]);
        $this->call(class: [RequesitosCuentaDeAhorroSeeder::class]);
        $this->call(class: [TablaDpfSeeder::class]);
        $this->call(class: [CaracteristicasDpfSeeder::class]);
        $this->call(class: [RequisitosDpfSeeder::class]);
        $this->call(class: [BeneficiosDpfSeeder::class]);
        $this->call(class: [InformacionImportanteSeeder::class]);
        $this->call(class: [BeneficiosDeSerSocioSeeder::class]);
        $this->call(class: [OpcionesDeSerSocioSeeder::class]);
        $this->call(class: [PersonalAdministracionSeeder::class]);
        $this->call(class: [PersonalVigilanciaSeeder::class]);
        $this->call(class: [ValoresFundamentalesSeeder::class]);
        $this->call(class: [ImagenValoresSeeder::class]);
    }
}
