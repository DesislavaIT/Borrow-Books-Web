<?php

require_once __DIR__ . '/../scripts/bootstrap.php';

\Core\Web\Template::configure(
    cache_path: DIR_ROOT . '/storage/cache/templates',
    cache_enabled: false
);

// Create and configure Injector (Dependency Injector Container).
$injector = \Core\DI\InjectorBuilder::make();
$factory_injector = require_once(DIR_ROOT . '/config/injector.php');
$factory_injector($injector);
$injector->build();

// Create the Application wrapper class and run it.
$application = inject(\Bookstore\Classes\Application::class);
$application->run();
