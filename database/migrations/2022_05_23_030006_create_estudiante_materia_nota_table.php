<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_materia_nota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudianteId');
            $table->unsignedBigInteger('materiaId');
            $table->string('nota');

            $table->foreign('estudianteId')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('MateriaId')->references('id')->on('Materias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiante_materia_nota');
    }
};
