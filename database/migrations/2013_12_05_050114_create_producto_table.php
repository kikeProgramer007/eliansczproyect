<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',40);
            $table->decimal('precio',6,2);
            $table->decimal('costo',6,2);
            $table->decimal('oferta',6,2)->nullable();
            $table->string('descripcion',50)->nullable();
            $table->tinyInteger('condicion')->default(1);
            $table->timestamps();
            $table->unsignedBigInteger('idcategoria');
            $table->foreign('idcategoria')->references('id')->on('categoria');
            $table->unsignedBigInteger('idmaterial');
            $table->foreign('idmaterial')->references('id')->on('material');
            $table->unsignedBigInteger('idmarca');
            $table->foreign('idmarca')->references('id')->on('marca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}