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
        Schema::create('horarios_agencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agencias_cooperativas_id')->constrained('agencias_cooperativas')->onDelete('cascade');
            $table->string('dias');
            $table->string('horas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_agencias');
    }
};
