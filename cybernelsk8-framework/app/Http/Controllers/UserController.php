<?php

namespace App\Http\Controllers;

use App\Models\User;
use Core\Http\Client\Request;
use Core\Http\Controller;

class UserController extends Controller{

    public function index () {
        try {
            
            $users = User::all();
            return response(array_map(fn($user) => $user->toArray(),$users));

        } catch (\Throwable $th) {

            return response($th->getMessage());

        }
    }

    public function store (Request $request) {
        
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
            'password' => 'required',
            'password_confirm' => 'required'
        ]);

        try {
            
            $user = User::create($data);
            $user->login();

            return response('Usuario creado exitosamente');

        } catch (\Throwable $th) {
            
            return response($th->getMessage());

        }
    }

    public function update (User $user, Request $request) {
    
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
        ]);

        try {
            
            $user->name = $data['name'];
            $user->email = $data['email'];
            // $user->save();

            $user->update();

            return response('Usuario actualizado exitosamente');

        } catch (\Throwable $th) {
            
            return response($th->getMessage());

        }
    
    }
    
    public function destroy (User $user) {

        try {
            
            $user->delete();
            return response('Usuario eliminado exitosamente');

        } catch (\Throwable $th) {

            return response($th->getMessage());
        }
    }
}