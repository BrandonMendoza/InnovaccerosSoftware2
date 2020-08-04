<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditingColumnToInventarioMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_materiales', function (Blueprint $table) {
            $table->dateTime('editing_at')->nullable();
            $table->integer('is_editing')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventario_materiales', function (Blueprint $table) {
            //
        });
    }
}
