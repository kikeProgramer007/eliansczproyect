<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallenotacompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallenotacompra', function (Blueprint $table) {
            $table->id();
            $table->decimal('costo',6,2);
            $table->smallInteger('cantidad');
            $table->decimal('importe',7,2);
            $table->unsignedBigInteger('idtallaproducto');
            $table->foreign('idtallaproducto')->references('id')->on('tallaproducto');
            $table->unsignedBigInteger('idnotacompra');
            $table->foreign('idnotacompra')->references('id')->on('notacompra');
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
        Schema::dropIfExists('detallenotacompra');
    }
}
