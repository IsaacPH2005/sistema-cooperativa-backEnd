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
        Schema::create('responsabilidad_socials', function (Blueprint $table) {
            $table->id();
            $table->string( 'titulo');
            $table->string( 'subtitulo');
            $table->string( 'pdf_1');
            $table->string( 'pdf_2');
            $table->string( 'imagen_pdf')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsabilidad_socials');
    }
};
