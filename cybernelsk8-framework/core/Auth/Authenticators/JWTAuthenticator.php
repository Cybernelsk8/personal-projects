<?php

namespace Core\Auth\Authenticators;

use App\Models\User;
use Core\Auth\Authenticatable;
use Core\JWT\JsonWebToken;


class JWTAuthenticator implements Authenticator {


    protected ?Authenticatable $authenticatable;
    protected ?JsonWebToken $jsonwebtoken;

    public function __construct() {
        $this->jsonwebtoken = new JsonWebToken();
    }

    public function login (Authenticatable $authenticatable) {
        
        $newToken = $this->jsonwebtoken->createJWT([
            'user_id' => $authenticatable->id()
        ]);

        $cookie = setcookie("auth_token", $newToken, [
            "expires" => time() + config('jwt.expired_token'),
            "path" => "/",
            "domain" => config('jwt.domains'), // Puedes especificar el dominio
            "secure" => false, // Solo sobre HTTPS
            "httponly" => true, // No accesible desde JavaScript
            "samesite" => "Strict" // Protege contra ataques CSRF
        ]);

        if(!$cookie){
            throw new \Error("No se pudo guardar el token");
        }
    }

    public function logout (Authenticatable $authenticatable) {
        setcookie("auth_token", "", time() - 3600, "/");
    }

    public function isAuthenticated (Authenticatable $authenticatable) : bool{
        if (isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
            $payload = $this->jsonwebtoken->decodeJWT($token);

            return $payload['user_id'] === $authenticatable->id();
        }

        throw new \Error("No existe la cookie correspondiente");

        return false;
    }

    public function resolve() : ?Authenticatable {

        if (isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
            $payload = $this->jsonwebtoken->decodeJWT($token);
            return User::find($payload['user_id']);
        }

        return null;
    }

}