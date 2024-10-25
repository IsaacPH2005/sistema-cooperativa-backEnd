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
        if (!Schema::hasTable('bienes_inmuebles')) {
            Schema::create('bienes_inmuebles', function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->decimal('precio', 10, 2);
                $table->integer('rebaja')->nullable();
                $table->text('datos');
                $table->dateTime('fecha');
                $table->boolean('estado')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bienes_inmuebles');
    }
};
