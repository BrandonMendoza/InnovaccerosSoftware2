<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('producto_id')->unsigned(false);
            $table->integer('documento_id')->unsigned(false);
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('clientes');
            $table->foreign('documento_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_documento');
    }
}
