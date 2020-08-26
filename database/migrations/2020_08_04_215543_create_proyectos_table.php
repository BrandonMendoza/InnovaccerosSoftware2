<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('proceso_id')->nullable()->unsigned(false);
            $table->integer('cliente_id')->unsigned(false);

            $table->string("peso_lbs",20);
            
            $table->integer('item')->nullable();
            $table->integer('cantidad')->nullable();
            $table->integer('status')->nullable();
            $table->integer('cotizado')->nullable();
            $table->integer('dias_habiles')->nullable();
            $table->integer('pagado_status')->nullable();

            $table->text('descripcion')->nullable();
            $table->text('notas')->nullable();

            $table->string("titulo",250);
            $table->string('work_order',30)->nullable();
            $table->string('plan_corte',30)->nullable();
            $table->string('heat_number',40)->nullable();
            $table->string('orden_compra',100)->nullable();
            $table->string('numero_factura',100)->nullable();
            $table->string('tipo_cambio',10)->nullable();
            $table->string('validez',20)->nullable();

            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('proyectos');
    }
}
