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
        Schema::create('tabla_dpfs', function (Blueprint $table) {
            $table->id();
            $table->integer('plazo'); // Plazo en días
            $table->decimal('interes_bs', 5, 4); // Interés en Bs.
            $table->decimal('interes_usd', 5, 4); // Interés en USD
            $table->boolean('estado')->default(true); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabla_dpfs');
    }
};
