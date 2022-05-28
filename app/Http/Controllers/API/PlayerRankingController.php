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
        if(auth('api')->user()) {
            // obtenim llista de jugadors registrats amb els seus percentages d'èxit
            $players_ranking = PlayerRankingInfo::players_ranking();

            return response()->json([
                'success' => true,
                'message' => 'Llista de jugadors registrats amnb els seus percentatges d\'èxit',
                'data' => $players_ranking,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure aquesta informació, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }
    
    
    public function show_average()
    {
        if(auth('api')->user()) {
            // obtenim el rànquing mitjà 
            $average_total_ranking = PlayerRankingInfo::average_ranking();

            return response()->json([
                'success' => true,
                'message' => 'Percentage mitjà d\'èxit de tots els jugadors registrats',
                'data' => $average_total_ranking,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure aquesta informació, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }

    public function show_loser()
    {
        // obtenim el jugador registrat amb el pitjor percentatge d'èxit
        if(auth('api')->user()) {
            
            return response()->json([
                'success' => true,
                'message' => 'jugador registrat amb el pitjor percentatge d\'èxit',
                'data' => PlayerRankingInfo::loser(),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure aquesta informació, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }

    public function show_winner()
    {
        // obtenim el jugador registrat amb el millor percentatge d'èxit
        if(auth('api')->user()) {
            
            return response()->json([
                'success' => true,
                'message' => 'jugador registrat amb el millor percentatge d\'èxit',
                'data' => PlayerRankingInfo::winner(),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per veure aquesta informació, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }
}

/**
 * classe creada "ex-professo" amb atributs nickname i percentatge d'èxit, i mètodes pee crear objectes (constructor), per obtenir el rànquing de jugadors registrats, el rànquing mitjà, el jugador amb pitjor percentatge d'èxit i el jugador amb millor percentage d'èxit
 * 
 */
class PlayerRankingInfo
{
    public string $nick_name;
    public float $percentage;

    public function __construct($nick_name, $percentage)
    {
        $this->nick_name = $nick_name;
        $this->percentage = $percentage;
    }

    public function loser()
    {   
        // obtenim rànquing amb nickname i percentatge èxit jugadors
        $ranking = self::players_ranking();
        // ordenem aquesta array associatiu en sentit descendent, comparant els percentages d'èxit
        usort($ranking, 'self::sort_descending');
        // finalment, retornem la info del darrer element de l'array ordenada
        return end($ranking)->nick_name;
    }

    public function winner()
    {
        // obtenim rànquing amb nickname i percentatge èxit jugadors
        $ranking = self::players_ranking();
        // ordenem aquesta array associatiu en sentit descendent, comparant els percentages d'èxit
        usort($ranking, 'self::sort_descending');
        // finalment, retornem la informació del primer element de l'array ordenada
        return reset($ranking)->nick_name;
    }

    // comparem percentages d'èxit a dins del rànquing de jugadors registrats
    public function sort_descending($value1, $value2)
    {
        // si els dos valors són iguals, retorna 0
        if($value1->percentage == $value2->percentage) return 0;
        // si el valor1 és menor que el valor2, retorna 1, en cas contrari, retorna -1
        return ($value1->percentage < $value2->percentage) ? 1 : -1;
    }

    // obtenim el rànquing de jugadors registrats
    public function players_ranking()
    {
        // obtenim els nicknames de tots els jugadors registrats al sistema, fent una consulta al model de dades dels usuaris
        $players = User::get('nick_name');
        // definim un array (arreglo) associatiu buit per desar les dades del rànquing: nickname del jugador i el seu percentatge d'exit 
        $players_ranking = [];
        // establim la posició inicial de l'array (index = 0)
        $i = 0;
        // iterem a través de l'objecte 'players' creat anteriorment
        foreach ($players as $player) {
            // desa el nickname del jugador
            $nick_name = $player->nick_name;
            // desa el percentatge d'èxit corresponent a aquest jugador
            $percentage = self::player_success_percentage($i + 1);
            // crea un objecte de la classe PlauerRankingInfo amb les dades anteriors i el desa a la posició actual de l'array
            $players_ranking[$i] = new PlayerRankingInfo($nick_name, $percentage);
            // avança a la següent posició de l'array
            $i++;
        }
        // finalment, retorna el rànquing dels jugadors registrats
        return $players_ranking;
    }

    // obtenim el percentage d'èxit per a cada jugador registrat
    public function player_success_percentage($id)
    {
        // desa el nombre de tirades de daus amb èxit del jugador amb 'id' = $id
        $games_win = Game::where('user_id',$id)->where('game_result', 'GUANYES')->count('id');
        // desa el nombre total de tirades de daus del jugador amb 'id' = $id
        $total_games = Game::where('user_id', $id)->count('id');
        // calcula el percentatge d'èxit dels jugador amb 'id = $id
        if($total_games == 0) {
            $percentage = 0;
        } else {
            $percentage = ($games_win / $total_games) * 100;
        }
        // finalment, el retorna
        return $percentage;
    }

    // obtenim el rànking mitjà
    public function average_ranking()
    {
        // desa el nombre total de tirades de daus amb èxit
        $total_games_win = Game::where('game_result', 'GUANYES')->count('id');
        // desa el nombre total de tirades de daus
        $total_games = Game::count('id');
        // calcula el percentage mitjà d'èxit
        $average_total_ranking = ($total_games_win / $total_games) * 100;
        // finalment, el retorna
        return $average_total_ranking;
    }
}



