<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserAuthController extends Controller
{
    /**
     * Login request
     */
    public function login(UserLoginRequest $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = auth()->user()->createToken('DAU AL SET Joc de daus Personal Access Client')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Usuari registrat ha entrat correctament',
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuari no registrat',
            ], 401);
        }
    }

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

    /**
     * Logout request
     * 
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Usuari registrat ha sortit correctament',
        ], 200);
    }
}
