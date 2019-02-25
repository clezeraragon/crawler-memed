<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePivotMedicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_medicamentos', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('id_medicamento')->unsigned();
            $table->integer('id_tipo_targeta')->unsigned();
            $table->integer('id_tipo_medicamento')->unsigned();
            $table->integer('id_valor')->unsigned();
            $table->integer('id_fabricante')->unsigned();
            $table->timestamps();


            $table->foreign('id_medicamento')->references('id')->on('medicamentos')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_tipo_targeta')->references('id')->on('tipos_targetas')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_tipo_medicamento')->references('id')->on('tipos_medicamentos')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_valor')->references('id')->on('valores')->onDelete('no action')->onUpdate('no action');
            $table->foreign('id_fabricante')->references('id')->on('fabricantes')->onDelete('no action')->onUpdate('no action');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_medicamentos');
    }
}
