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
        Schema::create('recomendaciones_de_seguridads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seguridad_id')->constrained('seguridad_tips')->onDelete('cascade')->onUpdate('cascade');
            $table->string('recomendacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recomendaciones_de_seguridads');
    }
};
