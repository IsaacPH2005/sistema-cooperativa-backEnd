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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->text("mision");
            $table->text("vision");
            $table->text("historia");
            $table->text("aspecto_legal");
            $table->text('img_vision')->nullable();
            $table->text('img_mision')->nullable();
            $table->text("imagen")->nullable();
            $table->text("asfi_imagen")->nullable();
            $table->text('logo')->nullable();
            $table->string('celular')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->decimal('latitud', 10, 8)->nullable(); // Permitir nulos
            $table->decimal('longitud', 10, 8)->nullable(); // Permitir nulos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
