<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotacompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notacompra', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_total',7,2);
            $table->smallInteger('impuesto');
            $table->unsignedBigInteger('idproveedor');
            $table->foreign('idproveedor')->references('id')->on('proveedor');
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
        Schema::dropIfExists('notacompra');
    }
}
