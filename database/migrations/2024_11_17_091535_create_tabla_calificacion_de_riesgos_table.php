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
        Schema::create('tabla_calificacion_de_riesgos', function (Blueprint $table) {
            $table->id();
            $table->string('celda_1');
            $table->string('celda_2');
            $table->string('celda_3');
            $table->string('celda_4');
            $table->string('celda_5');
            $table->string('celda_6');
            $table->string('celda_7');
            $table->string('celda_8');
            $table->string('celda_9');
            $table->string('celda_10');
            $table->date('fecha')->nullable();
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabla_calificacion_de_riesgos');
    }
};
