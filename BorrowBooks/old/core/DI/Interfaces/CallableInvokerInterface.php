<?php

namespace Core\DI\Interfaces;

interface CallableInvokerInterface
{
    /**
     * @param mixed $callable
     * @param array $parameters
     *
     * @return mixed
     */
    public function invoke(mixed $callable, array $parameters = []): mixed;
}
