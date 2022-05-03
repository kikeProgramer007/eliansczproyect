<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTallaproductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tallaproducto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idproducto');
            $table->foreign('idproducto')->references('id')->on('producto');
            $table->unsignedBigInteger('idtalla');
            $table->foreign('idtalla')->references('id')->on('talla');
            $table->smallInteger('stock');
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
        Schema::dropIfExists('tallaproducto');
    }
}
