<?php

use Core\Http\Client\Request;
use Core\Http\Client\Response;

function json(array $data, int $status = 200) : Response {
    return Response::json($data, $status);
}

function redirect(string $uri) : Response {
    return Response::redirect($uri);
}

function request() : Request {
    return app()->request;
}

function back(): Response {
    return redirect(session()->get('_previous','/'));
}

function response(array|string|null $data = null, int $status = 200 ) : Response  {
    return Response::response($data,$status);
}