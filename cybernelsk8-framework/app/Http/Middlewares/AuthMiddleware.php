<?php

namespace App\Http\Middlewares;

use Core\Http\Client\Request;
use Closure;
use Core\Http\Client\Response;
use Core\Http\Middlewares\Middleware;
use Core\JWT\JsonWebToken;

class AuthMiddleware implements Middleware{

    public function handle(Request $request, Closure $next): Response {
        
        $authToken = $request->cookies('auth_token');

        if(!is_null($authToken)){
            
            $jsonwebtoken = new JsonWebToken();
    
            if(!$jsonwebtoken->verifyJWT($authToken)) {
                return response(['message' => 'Not authenticated'],401);
            }

            return $next($request);    
        }

        return response(['message' => 'Not authenticated'],401);
    }

}