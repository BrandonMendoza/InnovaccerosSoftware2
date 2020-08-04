<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_materiales', function (Blueprint $table) {
            $table->id()->unsigned(false);
            $table->integer('material_cliente_id');
            $table->integer('status_id');
            $table->integer('orden_compra_id');
            $table->string('proyecto',50)->nullable();
            $table->string('tba',50);
            $table->integer('cantidad');
            $table->integer('item');
            $table->string('work_order',30);
            $table->string('plan_corte')->nullable();
            $table->string('heat_number',40)->nullable();
            $table->string('locacion_almacen',30)->nullable();

            $table->timestamps();

            $table->foreign('material_cliente_id')->references('id')->on('material_cliente');
            $table->foreign('status_id')->references('id')->on('status_inventario_materiales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario_materiales');
    }
}
