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
        Schema::create('bienes_adjudicados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->decimal('precio', 10,2);
            $table->integer('rebaja');
            $table->text('datos');
            $table->dateTime('fecha');
            $table->json('imagenes');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bienes_adjudicados');
    }
};
