<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void

     */
    public function up()
    {
        Schema::create('accesorios', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('acero_id');
            $table->string('numero_parte',50);
            $table->string('descripcion',200);
            $table->string('peso_kg',20)->nullable();

            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('acero_id')->references('id')->on('aceros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesorios');
    }
}
