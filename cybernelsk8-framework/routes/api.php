<?php

use App\Models\User;
use Core\Auth\Auth;
use Core\Routing\Route;

Auth::routes();

Route::get('/',fn() => response('Bienvenido a Muni-Framework'));

Route::get('/verify-authenticated/{edad}/{user}',function(User $user, int $edad) {
    return response([$user->toArray(),$edad]);
});






