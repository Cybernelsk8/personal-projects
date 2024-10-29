<?php

return [

    'password_encrypt_keys' => env('JWT_PASSWORD_ENCRYPT_KEYS','Cyb3rn3lsk8'),
    'expired_token' => env('JWT_EXPIRED_TOKEN',3600),
    'domains' => env('JWT_DOMAINS','localhost')

];