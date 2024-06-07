<?php

use Bookstore\Classes\Application;

if (!function_exists('application')) {
    function application(): Application
    {
        return inject(Application::class);
    }
}
