<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatalogoColumnToAccesoriosAndMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accesorios', function (Blueprint $table) {
            $table->integer('catalogo')->default(2);
        });


        Schema::table('materiales', function (Blueprint $table) {
           $table->integer('catalogo')->default(1); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accesorios_and_materiales', function (Blueprint $table) {
            //
        });
    }
}
