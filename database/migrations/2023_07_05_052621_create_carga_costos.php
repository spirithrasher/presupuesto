<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaCostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_costos', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_empresa');
            $table->integer('periodo');
            $table->date('fecha');
            $table->bigInteger('debe');
            $table->bigInteger('doc_sdo');
            $table->bigInteger('haber');
            $table->bigInteger('total');
            $table->text('glosa');
            $table->integer('cta_cod');
            $table->text('cta_nom');
            $table->integer('cc_nom');
            $table->string('cotipo');
            $table->integer('conum');
            $table->integer('anno');
            $table->integer('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carga_costos');
    }
}
