<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;

class PlayerRankingController extends Controller
{
    public function index()
    {
        if(auth('api')->user()->token()) {
            // llista de jugadors registrats amb els seus percentages d'èxit
            // cridem al mètode corresponent per obtenir-la
            $players_ranking = $this->players_ranking();

            return response()->json([
                'success' => true,
                'message' => 'llista de jugadors registrats amb percentatges d\'èxit',
                'data' => $players_ranking,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure una llista amb tots els jugadors registrats, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }
    
    
    public function show_average()
    {
        if(auth('api')->user()->token()) {

            $average_total_ranking = $this->get_average_ranking();

            return response()->json([
                'success' => true,
                'message' => 'Percentage mitjà d\'èxit de tots els jugadors registrats',
                'data' => $average_total_ranking,
            ], 200);
        }
    }

    public function show_loser()
    {
        //
    }

    public function show_winner()
    {
        //
    }

    public function players_ranking()
    {
        /**
         * obtenim els nicknames de tots els jugadors registrats al sistema
         * fent una consulta al model de dades dels usuaris
         */ 
        $players = User::get('nick_name');
        /** 
         * definim un array (arreglo) associatiu buit per desar les dades 
         * del rànquing: nickname del jugador i el seu percentatge d'exit 
         * 
         */ 
        $players_ranking = [];
        // establim la posició inicial de l'array (index = 0)
        $i = 0;
        /** 
         * iterem a través de l'objecte 'players' creat anteriorment,
         * desem el nickname de cada jugador a l'array associativa,
         * cridem el mètode correponent per calcular el seu percentatge d'èxit
         * i el desem també a l'array associativa
         * 
         */ 
        foreach ($players as $player) {
            // desa el nickname del jugador
            $players_ranking[$i]['nick_name'] = $player->nick_name;
            // desa el percentatge d'èxit corresponent a aquest jugador
            $players_ranking[$i]['percentage'] = $this->set_player_success_percentage($i + 1);
            $i++;
        }
        // retorna el rànquing dels jugadors registrats
        return $players_ranking;
    }

        /** 
         * alternativa no reeixida per crear el rànquing dels jugadors registrats:
         * definiim una classe smb els atributs nickname jugador i percentatge d'èxit
         * 
         */
        
        /*
        class PlayerRanking {
            private $nick_name;
            private $percentage;

            public function setNickname($nick_name)
            {
                $this->nick_name = $nick_name;
            }

            public function setPercentage($percentage)
            {
                $this->percentage = $percetage;
            }

            public function getNickname()
            {
                return $this->nick_name;
            }

            public function getPercentage()
            {
                return $this->percentage;
            }
        }

        
        $registered_players = User::count('id');

        $players = [];

        for((int) $i=0; $i < $registered_players; $i++) {
            // get the nick_name of the player
            $nick_name = (string) User::where('id',$i + 1)->get('nick_name');
            // get the amount of successiful dice-throwing games
            $games_win = Game::where('user_id',$i + 1)->where('game_result', 'GUANYES')->count('id');
            // get the total amount of dice-throwing games
            $total_games = Game::where('user_id', $i + 1)->count('id');
            // get the percentage of success
            if($total_games == 0) {
                $percentage = 0;
            } else {
                $percentage = ($games_win / $total_games) * 100;
            }
            // create an object of playersRanking to save the info
            $player_info = new playersRanking((string) $nick_name, $percentage);
            // add this object to the array of players
            $players[$i] = $player_info;
        }

        return $players;
        */
    

    public function set_player_success_percentage($id)
    {
        // get the amount of successiful dice-throwing games
        $games_win = Game::where('user_id',$id)->where('game_result', 'GUANYES')->count('id');
        // get the total amount of dice-throwing games
        $total_games = Game::where('user_id', $id)->count('id');
        // get the percentage of success
        if($total_games == 0) {
            $percentage = 0;
        } else {
            $percentage = ($games_win / $total_games) * 100;
        }

        return $percentage;
    }

    public function get_average_ranking()
    {
        $total_games_win = Game::where('game_result', 'GUANYES')->count('id');

        $total_games = Game::count('id');

        $average_total_ranking = ($total_games_win / $total_games) * 100;

        return $average_total_ranking;
    }
}
