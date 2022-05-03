<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->string('ci',10)->unique();
            $table->string('nombre',50);
            $table->char('sexo',1);
            $table->string('telefono',10);
            $table->string('direccion',60)->nullable();
        });

        DB::table('personal')->insert(array('ci'=>'12414590','nombre'=>'Jose Fernando','sexo'=>'M','telefono'=>'75514328','direccion'=>'Av. 7 calles'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal');
    }
}
