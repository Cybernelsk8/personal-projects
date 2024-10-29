<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'name'  => 'required|string',
            'email' => ['required','email','unique:users,email'],
            'password'  => 'required|string|min:8|max:15|confirmed'
        ]);

        try {
            
                $user = User::create([
                    'name' => ucwords(strtolower($request->name)),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                if($user){       
                    return response('Usuario creado exitosamente');
                }
            
            return response('No se puedo crear registro');
            
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
}
