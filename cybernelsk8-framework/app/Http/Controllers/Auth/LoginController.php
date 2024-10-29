<?php

namespace App\Http\Controllers\Auth;
use Core\Auth\Auth;
use Core\Http\Client\Request;
use Core\Http\Controller;

class LoginController extends Controller {

    public function authenticate(Request $request)  {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            
            if(Auth::attempt($credentials)){
                return response('Usuario autenticado correctamente');
            }

            return response('A provehido credenciales que no concuerdan con nuestros registros.',401);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function logout() {
        auth()->logout();
        return response('Cierre de sesion satisfactoria');
    }



}