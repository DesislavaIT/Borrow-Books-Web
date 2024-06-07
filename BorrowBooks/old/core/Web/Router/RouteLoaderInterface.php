<?php

namespace Core\Web\Router;

interface RouteLoaderInterface
{
    /**
     * @return void
     */
    public function load(): void;

    /**
     * @return Route[]
     */
    public function getRoutes(): array;
}
