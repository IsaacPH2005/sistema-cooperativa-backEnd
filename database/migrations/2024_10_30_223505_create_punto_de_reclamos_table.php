<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('punto_de_reclamos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_del_hecho');
            $table->string('categoria')->nullable();
            $table->string('sub_categoria')->nullable();
            $table->string('monto_comprometido')->nullable();
            $table->string('opciones_multiples_1')->nullable();
            $table->string('agencia');
            $table->text('descripcion');
            $table->string('tipo_persona');
            $table->string('representante_legal')->nullable();
            $table->string('numero_de_testimonio')->nullable();
            $table->string('nombre_o_razon_social');
            $table->string('numero_de_documento');
            $table->string('opciones_multiples_2')->nullable();
            $table->string('complemento')->nullable();
            $table->string('expedido_en')->nullable();
            $table->string('celular');
            $table->string('correo_electronico');
            $table->string('direccion');
            $table->string('medio_de_envio_de_respuesta')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('recibir_numero_de_reclamo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punto_de_reclamos');
    }
};
