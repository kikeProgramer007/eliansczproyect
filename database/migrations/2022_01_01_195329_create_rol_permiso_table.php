<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolPermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idrol');
            $table->foreign('idrol')->references('id')->on('rol');
            $table->unsignedBigInteger('idpermiso');
            $table->foreign('idpermiso')->references('id')->on('permiso');
            $table->tinyInteger('condicion')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol_permiso');
    }
}
