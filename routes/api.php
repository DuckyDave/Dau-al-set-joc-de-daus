<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\PlayerGameController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Un usuari específic vol entrar (login)
Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
// una persona vol registar-se com a usuari per poder jugar
Route::post('register', [UserAuthController::class, 'register'])->name('user.register');

// Crea un jugador nou: redirigeix cap a ruta per registrar-se, ja que totes dues accions són la mateixa
Route::post('players', function() {
    return redirect()->route('user.register');
})->name('api.players.store');
// Modifica el nom d'un jugador determinat
Route::put('players/{id}', [PlayerController::class, 'update'])->name('api.players.update');
// Un jugador específic realitza una tirada de daus
Route::post('players/{id}/games', [PlayerGameController::class, 'store'])->name('api.playerGame.store');
// Un jugador específic llista TOTS els seus jocs (TOTES les seves tiradescde daus)
Route::get('players/{id}/games', [PlayerGameController::class, 'show'])->name('api.playerGame.show');
// Un jugador específic elimina TOTS els seus jocs (TOTES les seves tirades de daus)
Route::delete('players/{id}/games', [PlayerGameController::class, 'destroy'])->name('api.playerGame.destroy');
