<?php

use Core\Database\Database;
use Core\DI\InjectionToken;
use Core\DI\InjectorBuilder;
use Core\DI\Provider;
use Core\DI\Provider\Loaders\DefaultProviderLoader;
use Core\Web\Router;

// Add all custom injection tokens here.
const CONTAINER = new InjectionToken('kernel.container');
const INJECTOR  = new InjectionToken('kernel.injector');
const DATABASE  = new InjectionToken('database');
const ROUTER    = new InjectionToken('web.router');

// Configure custom loaders and providers for the Injector here.
return (function(InjectorBuilder $builder): void {
    $builder
        ->addLoader(new DefaultProviderLoader(
            [DIR_ROOT . '/src/*'],
            [DIR_ROOT . '/src/Scripts']
        ))
        ->addProvider(new Provider(DATABASE, factory: function() {
            $configuration = [
                'host' => '127.0.0.1',
                'user' => 'root',
                'pass' => '',
                'name' => 'book_store_web'
            ];

            return new Database($configuration);
        }))
        ->addProvider(new Provider(ROUTER, factory: function() {
            $router         = new Router();
            $factory_router = require_once(DIR_ROOT . '/config/routes.php');
            $factory_router($router);

            return $router;
        }))
    ;
});
