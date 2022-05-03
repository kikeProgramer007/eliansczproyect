<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notaventa', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_pago',7,2);
            $table->decimal('descuento',6,2)->nullable();
            $table->decimal('monto_total',7,2);
            $table->unsignedBigInteger('idcliente');
            $table->foreign('idcliente')->references('id')->on('cliente');
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->tinyInteger('condicion')->default(1);
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
        Schema::dropIfExists('notaventa');
    }
}
