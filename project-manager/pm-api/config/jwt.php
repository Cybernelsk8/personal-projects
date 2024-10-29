<?php

return [

    'secret' => env('JWT_SECRET',null),
    'expired_token' => env('JWT_EXPIRED_TOKEN',60),
    'receivers' => [
        'http://localhost:5173',
    ]

];