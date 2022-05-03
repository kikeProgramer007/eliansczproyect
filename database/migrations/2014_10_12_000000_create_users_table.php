<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('idpersonal'); //El user obtiene el id de personal
            $table->foreign('idpersonal')->references('id')->on('personal');
            $table->unsignedBigInteger('idrol');
            $table->foreign('idrol')->references('id')->on('rol');
            $table->tinyInteger('condicion')->default(1);
        });

        DB::table('users')->insert(array('email'=>'jchilelaime@gmail.com', 'password' => Hash::make('12345'), 'idpersonal'=>1,'idrol'=>1));
        DB::table('users')->insert(array('email'=>'xthewonderlanx25996@gmail.com', 'password' => Hash::make('12345'), 'idpersonal'=>1,'idrol'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
