<?php

namespace Core\Server;

use Core\Http\Client\Request;
use Core\Http\Client\Response;

interface Server {

    public function getRequest() : Request ;
    public function sendResponse(Response $response) ;
    
}