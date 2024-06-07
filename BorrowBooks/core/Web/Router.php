<?php

namespace Core\Web;

use Core\HTTP\Request;
use Core\HTTP\Response;
use Core\Web\Router\Route;
use Core\Web\Router\RouteLoaderInterface;

class Router
{
    public array $routes;

    public ?Route $currentRoute = null;

    public function __construct()
    {
        $this->routes = [
            'GET'     => [],
            'POST'    => [],
            'PUT'     => [],
            'PATCH'   => [],
            'DELETE'  => [],
            'HEAD'    => [],
            'OPTIONS' => []
        ];
    }

    public function addLoader(RouteLoaderInterface $loader): static
    {
        $loader->load();

        foreach ($loader->getRoutes() as $route) {
            foreach ($route->methods as $method) {
                $this->add($method, $route->path, $route->getAction(), $route);
            }
        }

        return $this;
    }

    public function add(string $method, string $path, mixed $action, ?Route $route = null): static
    {
        $method = strtoupper($method);

        $path = preg_replace("/\//", '\\/', $path);
        $path = preg_replace("/\{([a-zA-Z]\w+)\}/", '(?P<\1>\w+)', $path);
        $path = preg_replace("/\{([a-zA-Z]\w+):([^}]+)}/", '(?P<\1>\2)', $path);
        $path = '/^' . $path . '$/i';

        $this->routes[$method][$path] = [$action, $route];

        return $this;
    }

    public function resolve(Request $request): mixed
    {
        $response = new Response(404, 'Page Not Found',
            '<h1>The page cannot be found.</h1>'
        );

        if (isset($this->routes[$request->method])) {
            foreach ($this->routes[$request->method] as $path => $action) {
                if (preg_match($path, $request->path, $matches)) {
                    $this->currentRoute = $action[1];
                    $action = $action[0];
                    if (is_array($action) and is_string($action[0]) and is_string($action[1])) {
                        $controller = inject($action[0]);
                        $response = call_user_func_array([$controller, $action[1]], [$request, $matches]);
                    } elseif (is_callable($action)) {
                        $response = call_user_func_array($action, $matches);
                    }
                }
            }
        }

        return $response;
    }
}
