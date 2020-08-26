<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoProcesoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_proceso_proyecto_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proyecto_proceso_id')->unsigned(false);
            $table->integer('proyecto_producto_id')->unsigned(false);
            $table->integer('user_id')->unsigned(false);

            $table->timestamps();

            $table->foreign('proyecto_proceso_id')->references('id')->on('proyectos_procesos');
            $table->foreign('proyecto_producto_id')->references('id')->on('proyecto_producto');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_proceso_proyecto_producto');
    }
}
