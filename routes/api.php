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

// Un usuari específic vol entrar (login)
Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
// una persona vol registar-se com a usuari per poder jugar
Route::post('register', [UserAuthController::class, 'register'])->name('user.register');

// Un usuari específic vol sortir (logout)
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:api')->name('user.logout');

// Rutes per a usuaris amb rol de jugador
Route::middleware('auth:api')->group(function () {
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
});

// Rutes per a usuaris amb rol d'administrador
Route::middleware('auth:api')->group(function () {
    // Un administrador vol veure la llista de jugadors registrats al sistema
    Route::get('players', [PlayerController::class, 'index'])->name('api.players.index');
});