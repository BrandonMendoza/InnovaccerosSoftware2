<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInventarioMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_materiales', function (Blueprint $table) {
            
            $table->integer('cliente_id');
            $table->integer('orden_compra_id')->nullable()->change();
            $table->string('tba',40)->nullable()->change();
            $table->integer('cantidad')->nullable()->change();
            $table->string('item',40)->nullable()->change();
            $table->string('work_order',40)->nullable()->change();

            $table->softDeletes();
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
        //
    }
}
