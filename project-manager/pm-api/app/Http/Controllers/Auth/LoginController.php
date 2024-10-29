<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        try {

            $aud = $request->header('Origin');
            $receivers = config('jwt.receivers');

            if(in_array($aud,$receivers)){

                if(Auth::attempt($credentials)){

                    $user = User::where('email',$request->email)->first();
                    
                    $payload = [
                        'sub' => $user->id,
                    ];

                    $accessToken = $user->createToken($payload, $aud);

                    if($accessToken) {

                        $cookie = cookie('access_token', $accessToken, config('jwt.expired_token'),'/','localhost', null, true);
        
                        return response($user)->withCookie($cookie);
                    }

                    return response('No authenticated',422);
                }
            }

            return response(['errors' => ['credenciales' => ['Credenciales invalidas']] ], 422);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }

        
    }

    public function verifyAuth() {

        return response(auth()->user());

    }

    public function permisosApp($user, $app) {

        $user = $user;

        if( isset($user->roles) && count($user->roles) > 0 ){

            $roles = $user->roles->filter(function($role) use($app) {
                $permisos = $role->permisos->map(function($permiso){
                    return ['id' => $permiso->id,'nombre' => $permiso->nombre ];
                });

                unset($role->permisos);
                unset($role->pivot);

                $role['permisos'] = $permisos;

                return $role->app == $app;

            })->values();


            unset($user->roles);
            $user['roles'] = $roles;
        }

        return $user;
    }

    public function logout() {
        Auth::logout();
        $cookie = Cookie::forget('access_token');
        return response(['message' => 'Successfully logged out'])
                         ->withCookie($cookie);
    }
}
