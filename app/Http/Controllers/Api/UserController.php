<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tamagotchi;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['data' => User::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $status = 200;
            $request->validate([
                'pseudo' => 'required|string|unique:\App\Models\User,pseudo',
            ]);

            if (User::where(['pseudo' => $request->pseudo])->get()->count() <= 0) {
                $iduser = User::insertGetId([
                    "pseudo" => $request->input('pseudo'),
                    "nb_attack" => 0,
                    "nb_hp" => 0,
                    "nb_accuracy" => 0,
                    "nb_amnesia" => 0,
                    "nb_red" => 0,
                    "nb_green" => 0,
                    "nb_blue" => 0,
                    "nb_black" => 0,
                    "currency" => 0,
                ]);
                $idtamagotchi = Tamagotchi::insertGetId([
                    "attack" => 5,
                    "hp" => 20,
                    "accuracy" => 20,
                    "red" => 0,
                    "green" => 0,
                    "blue" => 0,
                    "max" => 30,
                    "user_id" => $iduser,

                ]);
                $resp = [
                    "created" => true,
                    "data" => User::where(['pseudo' => $request->input('pseudo')])->with("tamagotchi")->first(),
                ];
            } else {
                $resp = [
                    "created" => false,
                    "message" => "pseudo is already taken by someone",
                ];
                $status = 404;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {

            $resp = [
                "created" => false,
                "message" => $e,
            ];
            $status = 404;
        }

        return response($resp, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $result = [];
        $user = User::where(['pseudo' => $name])->with('tamagotchi')->first();

        if (!empty($user)) {
            $result['data'] = $user;
            $code = 200;
        } else {
            $result['find'] = false;
            $code = 404;
        }
        return response($result, $code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                "pseudo" => "required|string",
                "nb_attack" => "required|integer",
                "nb_hp" => "required|integer",
                "nb_accuracy" => "required|integer",
                "nb_amnesia" => "required|integer",
                "nb_red" => "required|integer",
                "nb_green" => "required|integer",
                "nb_blue" => "required|integer",
                "nb_black" => "required|integer",
                "currency" => "required|integer",
                "next_loot" => "required | date",
                "tamagotchi.attack" => "required|integer",
                "tamagotchi.hp" => "required|integer",
                "tamagotchi.accuracy" => "required|integer",
                "tamagotchi.red" => "required|integer",
                "tamagotchi.green" => "required|integer",
                "tamagotchi.blue" => "required|integer",

            ]);
            $user = User::with("tamagotchi")->findOrFail($id);
            $user->pseudo = $request->input("pseudo");
            $user->nb_attack = $request->input("nb_attack");
            $user->nb_hp = $request->input("nb_hp");
            $user->nb_accuracy = $request->input("nb_accuracy");
            $user->nb_red = $request->input("nb_red");
            $user->nb_green = $request->input("nb_green");
            $user->nb_blue = $request->input("nb_blue");
            $user->nb_black = $request->input("nb_black");
            $user->nb_amnesia = $request->input("nb_amnesia");
            $user->currency = $request->input("currency");
            $user->next_loot = ($request->input("next_loot"));

            $user->tamagotchi->attack = $request->input("tamagotchi.attack");
            $user->tamagotchi->hp = $request->input("tamagotchi.hp");
            $user->tamagotchi->accuracy = $request->input("tamagotchi.accuracy");
            $user->tamagotchi->red = $request->input("tamagotchi.red");
            $user->tamagotchi->green = $request->input("tamagotchi.green");
            $user->tamagotchi->blue = $request->input("tamagotchi.blue");
            $user->save();
            $user->tamagotchi->save();

            $result["updated"] = true;
            $code = 200;
        } catch (ValidationException $e) {
            $result['updated'] = false;
            $result['errors'] = $e->err;
            $code = 404;
        }

        return response($result, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $pseudo
     * @return \Illuminate\Http\Response
     */
    public function destroy($pseudo)
    {
        $user = $this->show($pseudo);
        return response(['user' => $user], 200);
    }
}
