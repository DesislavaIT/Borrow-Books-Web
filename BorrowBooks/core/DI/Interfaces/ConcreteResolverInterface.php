<?php

namespace Core\DI\Interfaces;

interface ConcreteResolverInterface
{
    /**
     * @param string $token
     * @param array $parameters
     *
     * @return mixed
     */
    public function resolve(string $token, array $parameters = []): mixed;
}
