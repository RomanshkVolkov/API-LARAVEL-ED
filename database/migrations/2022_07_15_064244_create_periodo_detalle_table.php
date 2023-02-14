<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('carrera_id');
            $table->unsignedBigInteger('personal_id');
            $table->unsignedBigInteger('materia_id');
            $table->string('grupo')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('periodo_id')->references('id')->on('periodo');
            $table->foreign('carrera_id')->references('id')->on('carrera');
            $table->foreign('materia_id')->references('id')->on('materia');
            $table->foreign('personal_id')->references('id')->on('personal');
            $table->foreign('plan_id')->references('id')->on('plan');
            
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
        Schema::dropIfExists('periodo_detalle');
    }
}
