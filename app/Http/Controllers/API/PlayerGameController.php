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
        if(auth('api')->user()->id === $request->id) {
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
                'message' => 'Resultat de la tirada de daus',
                'data' => $player_game->game_result,
            ], 201);
        } else {
            return response()->json([
                'sucess' => false,
                'error' => 'Usuari no registrat.',
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
        if(auth('api')->user()->id === $id) {
            $player_games = User::find($id)->games()
                            ->select('game_result')->get();

            return response()->json([
                'success' => true,
                'message' => 'Tirades de daus realitzades fins ara',
                'data' => $player_games,
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'error' => 'Usuari no registrat.',
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
        if(auth('api')->user()->id === $id) {
            Game::destroy($id);

            return response()->json([
                'sucess' => true,
                'message' => 'Has eliminat TOTES les tirades de daus que has realitzat fins ara'
            ], 200);
        } else {
            return response()->json([
                'sucess' => false,
                'error' => 'Usuari no registrat.',
            ], 401);
        }
    }
}
