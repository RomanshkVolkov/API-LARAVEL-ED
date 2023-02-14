<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestaEvaluacionComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_evaluacion_comentario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_detalle_id');
            $table->text('comentario')->nullable();
            $table->foreign('periodo_detalle_id')->references('id')->on('periodo_detalle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta_evaluacion_comentario');
    }
}
