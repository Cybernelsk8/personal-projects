<?php 

namespace Core\JWT;

use Core\Kernel;

class JsonWebToken {

    protected string $newToken;
    protected string $header;
    protected string $payload;

    // Crear la clave privada y necesita contraseña para encriptarla
    // openssl genpkey -algorithm RSA -out private_key.pem -aes256 

    // Extrae la clave publica de la privada
    // openssl rsa -in private_key.pem -pubout -out public_key.pem

    public function createJWT (array $payloads) : string {

        $pathPrivateKey = 'file://'.realpath(Kernel::$root."\\storage\\keys");
        
        $password_encrypt_keys = config("jwt.password_encrypt_keys");
        $privateKey = openssl_pkey_get_private($pathPrivateKey.'\private_key.pem', $password_encrypt_keys );

        if(!$privateKey) {
            throw new \Error("No se pudo cargar la clave privada");
        }

        $this->header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $payload = [
            'iss' => config("jwt.domains"), 
            'iat' => time(), 
            'exp' => time() + config("jwt.expired_token"), 
        ];

        foreach ($payloads as $key => $value) {
            $payload[$key] = $value;
        }

        $this->payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($this->header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($this->payload));

        $signature = '';

        if (!openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new \Error("No se pudo firmar el JWT");
        }
        
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $this->newToken = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        
        return $this->newToken;

    }

    public function verifyJWT($jwt) : bool {

        if(is_null($jwt)){

            return false;
        }

        $publicKey = file_get_contents(Kernel::$root."/storage/keys/public_key.pem");
    
        list($header, $payload, $signature) = explode('.', $jwt);
        
        $base64UrlSignature = str_replace(['-', '_'], ['+', '/'], $signature);
        
        $signature = base64_decode($base64UrlSignature);
        
        $isValid = openssl_verify($header . "." . $payload, $signature, $publicKey, OPENSSL_ALGO_SHA256);
    
        return $isValid;
    }

    public function decodeJWT($jwt) : array {

        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
    
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payloadEncoded)), true);
    
        $currentTimestamp = time();
    
        if (isset($payload['iss']) && $payload['iss'] !== 'localhost') {
            throw new \Error("Issuer inválido.");
        }
    
        if (isset($payload['exp']) && $currentTimestamp > $payload['exp']) {
            throw new \Error("El token ha expirado.");
        }
    
        if (isset($payload['iat']) && $currentTimestamp < $payload['iat']) {
            throw new \Error("El token se emitió en un momento inválido.");
        }
    
        return $payload;
    }

}