<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material_id');
            $table->integer('cliente_id');
            $table->string('numero_parte',50);
            $table->string('almacen',20)->nullable();
            $table->string('locacion_almacen',30)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materiales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_cliente');
    }
}
