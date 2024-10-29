<?php

namespace Core\Routing;

use Closure;

class Route {

    protected string $uri;
    protected Closure|array $callback;
    protected string $regex;
    protected array $parameters;
    protected array $middlewares = [];

    public function __construct(string $uri, Closure|array $callback){
        $this->uri = $uri;
        $this->callback = $callback;
        $this->regex = preg_replace('/\{([a-zA-Z]+)\}/','([a-zA-Z0-9]+)',$uri);
        preg_match_all('/\{([a-zA-Z]+)\}/',$uri, $parameters);
        $this->parameters = $parameters[1];
    }

    public function uri() :string {
        return $this->uri;
    }

    public function callback() : Closure|array {
        return $this->callback;
    }

    public function middlewares() : array {
        return $this->middlewares;
    }
    public function setMiddlewares(array $aliasMiddlewares) : self {

        $middlewares = [];

        foreach ($aliasMiddlewares as $alias) {
            $middle = config("middleware.aliasMiddlewares.$alias");
            $middlewares[] = $middle;
        }

        $this->middlewares = array_map(fn($middleware) => new $middleware(),$middlewares);
        return $this;
    }

    public function hasMiddlewares() : bool {
        return count($this->middlewares) > 0;
    }

    public function matches(string $uri): bool {
        return preg_match("#^$this->regex/?$#", $uri);
        
    }

    public function hasParameters():bool {
        return count($this->parameters) > 0;
    }

    public function parseParameters(string $uri): array {
        preg_match("#^$this->regex$#", $uri, $arguments);
        return array_combine($this->parameters, array_slice($arguments, 1));
    }

    public static function load(string $routeDirectory) {
        foreach (glob("$routeDirectory/*.php") as $routeFile) {
            require_once $routeFile;
        }
    }

    public static function get(string $uri, Closure|array $callback) : Route {
        return app()->router->get($uri,$callback);
    }
    public static function post(string $uri, Closure|array $callback) : Route {
        return app()->router->post($uri,$callback);
    }
    public static function put(string $uri, Closure|array $callback) : Route {
        return app()->router->put($uri,$callback);
    }
    public static function patch(string $uri, Closure|array $callback) : Route {
        return app()->router->patch($uri,$callback);
    }
    public static function delete(string $uri, Closure|array $callback) : Route {
        return app()->router->delete($uri,$callback);
    }

    public static function group(array $attributes, Closure $callback): void {
        $router = app()->router;
        $router->addGroup($attributes, $callback);
    }

}