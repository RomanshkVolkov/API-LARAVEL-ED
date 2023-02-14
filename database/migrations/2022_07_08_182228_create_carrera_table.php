<?php

use App\Models\Carrera;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->id();
            $table->string("carrera");
            $table->string("abreviatura");
            $table->integer("nivel"); 
            $table->unsignedBigInteger("departamento_id");
            $table->foreign('departamento_id')->references('id')->on('departamento');

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
        Schema::dropIfExists('carrera');
    }
}
