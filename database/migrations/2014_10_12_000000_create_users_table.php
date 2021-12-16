<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("pseudo");
            $table->integer("nb_attack");
            $table->integer("nb_hp");
            $table->integer("nb_accuracy");
            $table->integer("nb_amnesia");
            $table->integer("nb_red");
            $table->integer("nb_green");
            $table->integer("nb_blue");
            $table->integer("nb_black");
            $table->integer("currency");
            $table->dateTime("next_loot")->nullable()->default(now());
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
        Schema::dropIfExists('users');
    }
}
