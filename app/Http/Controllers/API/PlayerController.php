<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class PlayerController extends Controller
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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
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
        if(auth('api')->user()->id == $request->id) {

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
                'message' => 'Per modificar el nom d\'un jugador, has de estar'
                . ' registrat prèviament i entrar amb les teves credencials'
                . ' (adreça de correu electrònic i contrasenya) per generar un'
                . ' token vàlid',
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
