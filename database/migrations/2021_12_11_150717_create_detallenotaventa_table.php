<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallenotaventaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallenotaventa', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',6,2);
            $table->smallInteger('cantidad');
            $table->decimal('total',7,2);
            $table->unsignedBigInteger('idtallaproducto');
            $table->foreign('idtallaproducto')->references('id')->on('tallaproducto');
            $table->unsignedBigInteger('idnotaventa');
            $table->foreign('idnotaventa')->references('id')->on('notaventa');
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
        Schema::dropIfExists('detallenotaventa');
    }
}
