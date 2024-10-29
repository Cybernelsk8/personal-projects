<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Core\Crypto\Bcrypt;
use Core\Http\Client\Request;
use Core\Http\Controller;

class RegisterController extends Controller {

    public function register(Request $request)  {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
            'password' => 'required',
            'password_confirm' => 'required'
        ]);    

        try {
            
            if($data['password'] === $data['password_confirm']){

                $user = User::create([
                    'name' => ucwords($data['name']),
                    'email' => strtolower($data['email']),
                    'password' => Bcrypt::hash($data['password'])
                ]);
    
                $user->login();
    
                return response('Usuario creado satisfactoriamente');
            }

            return response(['error'=> ['password_confirm' => 'Los passwords ingresados no concuerdan']] ,422);

        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}