<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos_procesos', function (Blueprint $table) {
            $table->id()->unsigned(false);
            $table->integer('proyecto_id');
            $table->integer('proceso_id');
            $table->timestamps();

            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_procesos');
    }
}
