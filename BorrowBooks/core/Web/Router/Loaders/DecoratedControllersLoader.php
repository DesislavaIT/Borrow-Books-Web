<?php

namespace Core\Web\Router\Loaders;

use Core\Web\Router\Route;
use Core\Web\Router\RouteLoaderInterface;

class DecoratedControllersLoader implements RouteLoaderInterface
{
    /** @var Route[] $routes */
    private array $routes = [];

    public function __construct(
        private string $directory
    ) {
        $this->directory = "$this->directory/*.php";
    }

    /**
     * @return void
     *
     * @throws \ReflectionException
     */
    public function load(): void
    {
        foreach (glob($this->directory) as $file) {
            if (!is_file($file)) continue;

            $class_name = extract_namespace($file) . '\\' . pathinfo($file)['filename'];

            $reflection = new \ReflectionClass($class_name);

            foreach ($reflection->getMethods() as $method) {
                $routes = $method->getAttributes(Route::class);
                foreach ($routes as $route) {
                    $route = $route->newInstance();
                    /** @var Route $route */
                    $route->setAction([$class_name, $method->getName()]);

                    $this->routes[] = $route;
                }
            }
        }
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
