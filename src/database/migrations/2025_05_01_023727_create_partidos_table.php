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
        Schema::create('partidos', function (Blueprint $table) {
            $table->bigIncrements('id_partido');
            $table->unsignedBigInteger('id_equipo_local');
            $table->unsignedBigInteger('id_equipo_visitante');
            $table->string('resultado')->nullable();
            $table->timestamps();

            $table->foreign('id_equipo_local')->references('id_equipo')->on('equipos')->onDelete('cascade');
            $table->foreign('id_equipo_visitante')->references('id_equipo')->on('equipos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
