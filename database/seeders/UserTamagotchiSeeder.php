<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTamagotchiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $dsUk = DB::table('users')->insertGetId([
            "pseudo" => "darksauceUk",
            "nb_attack" => 0,
            "nb_hp" => 0,
            "nb_accuracy" => 0,
            "nb_amnesia" => 0,
            "nb_red" => 0,
            "nb_green" => 0,
            "nb_blue" => 0,
            "nb_black" => 0,
            "currency" => 1,
        ]);
        DB::table('tamagotchis')->insertGetId([
            "attack" => 0,
            "hp" => 0,
            "accuracy" => 0,
            "red" => 0,
            "green" => 0,
            "blue" => 0,
            "max" => 30,
            "user_id" => $dsUk,
        ]);
    }
}
