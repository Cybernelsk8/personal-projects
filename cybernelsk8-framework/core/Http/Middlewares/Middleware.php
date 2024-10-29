<?php

namespace Core\Http\Middlewares;

use Closure;
use Core\Http\Client\Request;
use Core\Http\Client\Response;

interface Middleware {

    public function handle(Request $request, Closure $next): Response;
    
}