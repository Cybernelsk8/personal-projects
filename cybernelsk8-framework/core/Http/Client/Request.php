<?php

namespace Core\Http\Client;

use Core\Http\Exceptions\HttpNotFoundException;
use Core\Routing\Route;
use Core\Validation\Validator;

class Request {
    
    protected string $uri;
    protected Route $route;
    protected string $method;
    protected array $data;
    protected array $query;
    protected array $headers = [];
    protected array $cookies = [];


    public function uri() : string {
        return $this->uri;
    }

    public function setUri(string $uri) : self {
        $this->uri = $uri;
        return $this;
    }

    public function setRoute(Route $route) : self {
        $this->route = $route;
        return $this;
    }

    
    public function route() : Route {
        return $this->route;
    }
    
    public function setMethod(string $method) : self {
        $this->method = $method;
        return $this;
    }
    public function method() : string {
        return $this->method;
    }

    public function headers(string $key = null) : array|string|null {
        if(is_null($key)){
            return $this->headers;
        }

        return $this->headers[strtolower($key)] ?? null;
    }

    public function cookies(string $key = null) : array|string|null {

        if($this->headers('cookie')){

            $cookies = $this->headers('cookie');
            $cookies = explode(";",$cookies);
    
            foreach ($cookies as $cookie) {
                $cookie = trim($cookie);
                list($name,$value) = explode("=",$cookie,2);
                $this->cookies[$name] = $value;
            }

            if(is_null($key)){
                return $this->cookies;
            }
    
            return $this->cookies[strtolower($key)] ?? null;
        }

        throw new HttpNotFoundException("No hay cookies",422);
        
    }

    public function setHeaders(array $headers) : self {
        foreach ($headers as $header => $value) {
            $this->headers[strtolower($header)] = $value;
        }
        return $this;
    }

    public function __get($key) {
        return $this->data[$key] ?? null;
    }


    public function data(?string $key = null) : array|string|null {
        if(is_null($key)){
            return $this->data;
        }

        return $this->data[$key] ?? null;
    }

    public function setPostData(array $data) : self {
        $this->data = $data;
        return $this;
    }

    public function query(?string $key = null) : array|string|null {
        if(is_null($key)){
            return $this->query;
        }
        return  $this->query[$key] ?? null;
    }

    public function setQueryParameters(array $query) : self {
        $this->query = $query;
        return $this;
    }

    public function routeParameters(?string $key = null): array|string|null { 

        $parameters = $this->route->parseParameters($this->uri);
        
        if(is_null($key)){
            return $parameters;
        }
        return $parameters[$key] ?? null;
    }

    public function validate(array $rules, array $messages = []) : array {
        $validator = new Validator($this->data);
        return $validator->validate($rules,$messages);
    }
    
}