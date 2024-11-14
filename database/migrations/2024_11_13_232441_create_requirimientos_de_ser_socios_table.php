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
        Schema::create('requirimientos_de_ser_socios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ser_socio_id')->constrained('opciones_de_ser_socios')->onDelete('cascade')->onUpdate('cascade');
            $table->text('requerimientos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirimientos_de_ser_socios');
    }
};
