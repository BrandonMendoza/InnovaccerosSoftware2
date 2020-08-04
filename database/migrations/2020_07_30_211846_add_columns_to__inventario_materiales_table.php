<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToInventarioMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_materiales', function (Blueprint $table) {
            $table->dropColumn('locacion_almacen');
            $table->timestamp('recibido_el')->nullable();
            $table->integer('cantidad_faltante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_inventario_materiales', function (Blueprint $table) {
            //
        });
    }
}
