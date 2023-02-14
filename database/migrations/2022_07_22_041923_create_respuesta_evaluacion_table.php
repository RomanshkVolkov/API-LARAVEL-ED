<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestaEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_evaluacion_id');
            $table->integer('puntos')->nullable();
            $table->foreign('pregunta_evaluacion_id')->references('id')->on('pregunta_evaluacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta_evaluacion');
    }
}
