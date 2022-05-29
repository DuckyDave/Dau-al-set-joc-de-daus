<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserAuthController extends Controller
{
    /**
     * Login request for players
     */
    public function playerLogin(UserLoginRequest $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $token = auth()->user()->createToken('DAU AL SET Joc de daus Personal Access Client')->accessToken;
            
            $nick_name = auth()->user()->nick_name;
            return response()->json([
                'success' => true,
                'message' => $nick_name . ', has entrat correctament, pots continuar',
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
     * Register request for players
     */
    public function playerRegister(UserRegisterRequest $request)
    {
        $user = new User;

        ($request->nick_name) ? $user->nick_name = $request->nick_name 
        : $user->nick_name = 'anònim';

        $user->email = $request->email;

        $user->password = bcrypt($request->password);
            
        $user->save();

        //$user->assignRole('player');

        $token = $user->createToken('DAU AL SET Joc de daus Personal Access Token')->accessToken;

        return response()->json([
            'sucess' => true,
            'message' => 'Nou usuari '. $user->nick_name . ', registrat'
            . ' correctament. Per continuar, has d\'entrar amb les teves'
            . ' credencials (adreça de correu electrònic i contrasenya)'
            . ' per generar un token vàlid',
            'token' => $token,
        ], 200);
    }

    /**
     * Login request for administrators
     */
    public function adminLogin(UserLoginRequest $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $token = auth()->user()->createToken('DAU AL SET Joc de daus Personal Access Client')->accessToken;
            
            $nick_name = auth()->user()->nick_name;
            return response()->json([
                'success' => true,
                'message' => $nick_name . ', has entrat correctament, pots continuar',
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
     * Register request for administrators
     */
    public function adminRegister(UserRegisterRequest $request)
    {
        $user = new User;

        ($request->nick_name) ? $user->nick_name = $request->nick_name 
        : $user->nick_name = 'anònim';

        $user->email = $request->email;

        $user->password = bcrypt($request->password);
            
        $user->save();

        //$user->assignRole('admin');

        $token = $user->createToken('DAU AL SET Joc de daus Personal Access Token')->accessToken;

        return response()->json([
            'sucess' => true,
            'message' => 'Nou usuari '. $user->nick_name . ', registrat'
            . ' correctament. Per continuar, has d\'entrar amb les teves'
            . ' credencials (adreça de correu electrònic i contrasenya)'
            . ' per generar un token vàlid',
            'token' => $token,
        ], 200);
    }

    /**
     * Logout request
     * 
     */
    public function logout(Request $request)
    {
        $nick_name = auth()->user()->nick_name;

        $token = auth('api')->user()->token();
        
        $token->revoke();

        return response()->json([
            'success' => true,
            'message' => $nick_name . ', has sortit correctament',
        ], 200);
    }
}
