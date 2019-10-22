<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->string('numero_factura');
            $table->string('articulos');
            $table->integer('total_compra');
            $table->unsignedBigInteger('id_tarjeta');
            $table->timestamps();
            $table->foreign('id_tarjeta')->references('id')->on('tarjetas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
