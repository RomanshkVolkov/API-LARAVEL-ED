<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntaEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pregunta_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_detalle_id');
            $table->unsignedBigInteger('pregunta_id');

            $table->foreign('pregunta_id')->references('id')->on('pregunta');
            $table->foreign('periodo_detalle_id')->references('id')->on('periodo_detalle');
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
        Schema::dropIfExists('pregunta_evaluacion');
    }
}
