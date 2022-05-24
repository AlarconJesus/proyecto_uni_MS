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
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('trayecto');
            $table->string('trimestre');
            $table->foreignId('id_carrera')
                ->nullable()
                ->constrained('carreras')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }
    // borrar la tabla sedes!! desde phpmyadmin

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materias');
    }
};
