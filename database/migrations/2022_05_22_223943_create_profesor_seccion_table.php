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
        Schema::create('profesor_seccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profesorId');
            $table->unsignedBigInteger('seccionId');

            $table->foreign('profesorId')->references('id')->on('profesors')->onDelete('cascade');
            $table->foreign('seccionId')->references('id')->on('seccions')->onDelete('cascade');
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
        Schema::dropIfExists('profesor_seccion');
    }
};
