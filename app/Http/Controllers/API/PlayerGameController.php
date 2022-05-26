<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;

class PlayerGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth('api')->user()->id == $request->id) {

            $nick_name = auth()->user()->nick_name;

            $player_game = new Game;
        
            $player_game->user_id = $request->id;
            
            $player_game->dice_1 = mt_rand(1,6);
            
            $player_game->dice_2 = mt_rand(1,6);
            
            if (((int) $player_game->dice_1 + (int) $player_game->dice_2) == 7) {
                $player_game->game_result = 'GUANYES';
            } else {
                $player_game->game_result = 'PERDS';
            }

            $player_game->save();

            return response()->json([
                'success' => true,
                'message' => 'Resultat de la tirada de daus, ' . $nick_name,
                'data' => $player_game->game_result,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per realitzar una tirada de daus, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth('api')->user()->id == $id) {

            $nick_name = auth()->user()->nick_name;

            $player_games = User::find($id)->games()
                            ->select('game_result')->get();

            return response()->json([
                'success' => true,
                'message' => 'Tirades de daus fins ara, ' . $nick_name,
                'data' => $player_games,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure una llista amb totes les tirades de daus que has realitzat fins ara, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya( per generar un token d\'accés vàlid',
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth('api')->user()->id == $id) {

            $nick_name = auth()->user()->nick_name;

            Game::where('user_id', $id)->delete();

            return response()->json([
                'sucess' => true,
                'message' => $nick_name . ', has eliminat TOTES les tirades de daus que'
                . ' has realitzat fins ara'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per eliminar TOTES les tirades de daus que has realitzat fins ara, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }
}
