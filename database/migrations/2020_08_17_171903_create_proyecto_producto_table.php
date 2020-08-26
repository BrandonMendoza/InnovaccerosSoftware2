<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proyecto_id')->unsigned(false);
            $table->integer('producto_id')->unsigned(false);
            $table->integer('proceso_id')->unsigned(false);

            $table->string('work_order',50)->nullable();
            $table->string('item',50)->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('heat_number',100)->nullable();
            $table->text('notas')->nullable();
            $table->string('hrs_labor',30)->nullable();
            $table->integer('pintura_id')->nullable();

            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_producto');
    }
}

