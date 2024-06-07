<?php

namespace Core\DI\Interfaces;

interface ContainerInterface
{
    /**
     * @param string|InjectionTokenInterface $token
     *
     * @return mixed
     *
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function get(string|InjectionTokenInterface $token): mixed;

    /**
     * @param string|InjectionTokenInterface $token
     *
     * @return bool
     */
    public function has(string|InjectionTokenInterface $token): bool;
}
