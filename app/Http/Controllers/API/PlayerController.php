<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class PlayerController extends Controller
{
    public function __construct() 
    {
        //$this->middleware('role:player');
        //$this->middleware('role:adininstrator');
        $this->middleware('can:create player')->only('store');
        $this->middleware('can:update player nickname')->only('update');
    }

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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if(auth('api')->user() && auth('api')->user()->hasRole('administrator')) {

            $user = new User;

            ($request->nick_name) ? $user->nick_name = $request->nick_name 
            : $user->nick_name = 'anònim';

            $user->email = $request->email;

            $user->password = bcrypt($request->password);
                
            $user->save();

            $token = $user->createToken('DAU AL SET Joc de daus Personal Access Token')->accessToken;

            return response()->json([
                'sucess' => true,
                'message' => 'Nou usuari '. $user->nick_name . ', registrat'
                . ' correctament. Per continuar, has d\'entrar amb les teves'
                . ' credencials (adreça de correu electrònic i contrasenya)'
                . ' per generar un token vàlid',
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per modificar el nom d\'un jugador, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if((auth('api')->user()->id == $request->id) && (auth('api')->user()->hasRole('player'))) {

            $user = User::find($request->id);

            ($request->nick_name) ? $user->nick_name = $request->nick_name
            : $user->nick_name = 'anònim';
            
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Nom del jugador: ' . $user->nick_name,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Accés denegat',
                'message' => 'Per modificar el nom d\'un jugador, has d\'entrar amb les teves credencials (adreça de correu electrònic i contrasenya) per generar un token d\'accés vàlid',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
