<?php

use Core\DI\Exceptions\ContainerException;
use Core\DI\Exceptions\ProviderNotFoundException;
use Core\DI\Exceptions\ResolvingException;
use Core\DI\InjectionToken;
use Core\DI\Injector;

if (!function_exists('inject')) {
    /**
     * @template T of mixed
     * @template-covariant U of mixed
     *
     * @param InjectionToken<U>|class-string<T> $token
     *
     * @return T|U
     *
     * @throws ContainerException
     * @throws ProviderNotFoundException
     * @throws ResolvingException
     * @throws ReflectionException
     */
    function inject(mixed $token): mixed
    {
        return Injector::root()->get($token);
    }
}
