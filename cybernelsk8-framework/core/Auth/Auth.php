<?php

namespace Core\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middlewares\AuthMiddleware;
use App\Models\User;
use Core\Auth\Authenticators\Authenticator;
use Core\Crypto\Bcrypt;
use Core\Routing\Route;

class Auth {
    
    public static function user() : ?Authenticatable {
        return app(Authenticator::class)->resolve();
    }

    public static function isGuest() : bool {
        return is_null(self::user());
    }

    public static function attempt(array $credentials) : bool {



        $username = config('auth.field_username');

        if(isset($credentials[$username])) {

            $user = User::firstWhere($username,$credentials[$username]);
            if(is_null($user) || !Bcrypt::verify($credentials['password'],$user->password)){
                return false;
            }

            $user->login();

            return true;

        }
    }

    public static function routes() {
        Route::post('/register',[RegisterController::class,'register']);
        Route::post('/login',[LoginController::class,'authenticate']);
        Route::get('/logout',[LoginController::class,'logout'])->setMiddlewares(['auth']);
    }
}