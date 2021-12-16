<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTamagotchisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamagotchis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer("hp");
            $table->integer("attack");
            $table->integer("accuracy");
            $table->integer("red");
            $table->integer("green");
            $table->integer("blue");
            $table->integer("max");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamagotchis');
    }
}
