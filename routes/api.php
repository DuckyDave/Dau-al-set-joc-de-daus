<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

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
