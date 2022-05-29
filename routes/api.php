<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\PlayerGameController;
use App\Http\Controllers\API\PlayerRankingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Un usuari específic vol entrar (login)
Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
// una persona vol registar-se com a usuari per poder jugar
Route::post('register', [UserAuthController::class, 'register'])->name('user.register');

// Un usuari específic vol sortir (logout)
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:api')->name('user.logout');

// Rutes per a usuaris amb rol de jugador
Route::middleware('auth:api')->group(function () {
    // Modifica el nom d'un jugador determinat
    Route::put('players/{id}', [PlayerController::class, 'update'])->name('api.players.update');
    // Un jugador específic realitza una tirada de daus
    Route::post('players/{id}/games', [PlayerGameController::class, 'store'])->name('api.playerGame.store');
    // Un jugador específic llista TOTS els seus jocs (TOTES les seves tiradescde daus)
    Route::get('players/{id}/games', [PlayerGameController::class, 'show'])->name('api.playerGame.show');
    // Un jugador específic elimina TOTS els seus jocs (TOTES les seves tirades de daus)
    Route::delete('players/{id}/games', [PlayerGameController::class, 'destroy'])->name('api.playerGame.destroy');
});

// Rutes per a usuaris amb rol d'administrador
Route::middleware('auth:api')->group(function () {
    // Un adminsitrador específic crea un jugador nou
    Route::post('players', [PlayerController::class, 'store'])->name('api.players.store');
    // Un administrador específic vol veure la llista de jugadors registrats amb els seus percentages d'èxit
    Route::get('players', [PlayerRankingController::class, 'index'])->name('api.playersRanking.index');
    // Un administrador específic vol veure la llista dels jugadors registrats i el percentage mitjà d'exit
    Route::get('players/ranking', [PlayerRankingController::class, 'show_average'])->name('api.playersRanking.average');
    // Un administrador específic vol veure la informació jugador amb el pitjor percentage d'exit
    Route::get('players/ranking/loser', [PlayerRankingController::class, 'show_loser'])->name('api.playersRanking.loser');
    // Un administrador específic vol veure la informació del jugador amb el millor percentage d'exit
    Route::get('players/ranking/winner', [PlayerRankingController::class, 'show_winner'])->name('api.playersRanking.winner');
});