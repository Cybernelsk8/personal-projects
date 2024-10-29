<?php

namespace Core\Routing;

use Closure;
use Core\Container\DependencyInjection;
use Core\Http\Client\Request;
use Core\Http\Client\Response;
use Core\Http\Exceptions\HttpNotFoundException;

class Router {

    protected array $routes = [];
    protected array $groupAttributes = [];

    public function resolveRoute(Request $request) : Route {
        foreach ($this->routes[$request->method()] as $route) {
            if($route->matches($request->uri())){
                return $route;
            }
        }

        throw new HttpNotFoundException();
        
    }

    public function  resolve(Request $request) : Response {
        $route = $this->resolveRoute($request);
        $request->setRoute($route);
        $callback = $route->callback();
        
        if(is_array($callback)){
            $controller = new $callback[0];
            $callback[0] = $controller;
        }

        $params = DependencyInjection::resolveParameters($callback,$request->routeParameters());

        return $this->runMiddlewares(
            $request,
            $route->middlewares(),
            fn() => call_user_func($callback,...$params)
        );
    }

    protected function runMiddlewares(Request $request, array $middlewares, $target) {
        if(count($middlewares) == 0) {
            return $target($request);
        }

        return $middlewares[0]->handle(
            $request, 
            fn($request) => $this->runMiddlewares($request, array_slice($middlewares,1), $target)
        );
    }

    protected function registerRoute(string $method, string $uri, Closure|array $callback) : Route {

        if (isset($this->groupAttributes['prefix'])) {
            $uri = "/".$this->groupAttributes['prefix'].$uri;
        }

        $route = new Route($uri,$callback);

        if (isset($this->groupAttributes['middleware'])) {
            $route->setMiddlewares($this->groupAttributes['middleware']);
        }

        $this->routes[$method][] = $route;
        return $route;
    }

    public function get(string $uri, Closure|array $callback) : Route {
        return $this->registerRoute('GET',$uri,$callback);
    }

    public function post(string $uri, Closure|array $callback) : Route {
        return $this->registerRoute('POST',$uri,$callback);
    }
    public function put(string $uri, Closure|array $callback) : Route {
        return $this->registerRoute('PUT',$uri,$callback);
    }

    public function patch(string $uri, Closure|array $callback) : Route {
        return $this->registerRoute('PATCH',$uri,$callback);
    }

    public function delete(string $uri, Closure|array $callback) : Route {
        return $this->registerRoute('DELETE',$uri,$callback);
    }

    public function addGroup(array $attributes, Closure $callback): void {
        $parentGroupAttributes = $this->groupAttributes;
        $this->groupAttributes = array_merge($this->groupAttributes, $attributes);
        $callback();
        $this->groupAttributes = $parentGroupAttributes;
    }
}