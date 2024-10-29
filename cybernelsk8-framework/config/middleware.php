<?php

return [

    // AQUI SE REGISTRAN TODOS LOS MIDDLEWARES A UTILIZAS
    
    'aliasMiddlewares' => [
        'auth' => App\Http\Middlewares\AuthMiddleware::class,
    ]
];