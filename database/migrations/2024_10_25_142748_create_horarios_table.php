<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar si la tabla 'agencias' existe para evitar problemas de clave foránea
      /*   if (!Schema::hasTable('agencias')) {
            throw new Exception("La tabla 'agencias' no existe. Por favor, créala primero.");
        } */
        
        if (!Schema::hasTable('horarios')) {
            Schema::create('horarios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('agencia_id')->constrained('agencias')->onDelete('cascade');
                $table->string('dias');
                $table->string('horas')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
