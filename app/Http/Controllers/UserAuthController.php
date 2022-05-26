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
                'message' => 'Usuari, has entrat correctament, pots continuar',
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'No existeix cap usuari registrat amb aquestes '
                . 'credencials (adreça de correu electrònic i contrasenya)',
                'message' => 'Per entrar, has de estar registrat prèviament',
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
            'message' => 'Nou usuari registrat correctament',
            'token' => $token,
        ], 200);
    }

    /**
     * Logout request
     * 
     */
    public function logout(Request $request)
    {
        auth('api')->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Usuari, has sortit correctament',
        ], 200);
    }
}
