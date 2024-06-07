<?php

use Core\Web\Router;
use Core\Web\Router\Loaders\DecoratedControllersLoader;

return (function(Router $router): void {
    $router->addLoader(new DecoratedControllersLoader(DIR_ROOT . '/src/Controllers'));
});
