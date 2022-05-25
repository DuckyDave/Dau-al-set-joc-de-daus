<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserAuthController extends Controller
{
    /**
     * Register request
     */
    public function register(UserRegisterRequest $request)
    {
        $user = new User;

        ($request->nick_name) ? $user->nick_name = $request->nick_name 
        : $user->nick_name = 'anònim';

        $user->email = $request->email;

        $user->password = bcrypt($request->password);
            
        $user->save();

        $token = $user->createToken('DAU AL SET Joc de daus Personal Access Token')->accessToken;

        return response()->json([
            'sucess' => true,
            'message' => 'Usuari registrat correctament',
            'token' => $token,
        ], 200);
    }
}
