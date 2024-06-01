<?php

namespace Core\DI\Attributes;

use Core\DI\Interfaces\InjectionTokenInterface;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class Inject
{
    /**
     * @param string|InjectionTokenInterface $token
     */
    public function __construct(
        private readonly string|InjectionTokenInterface $token
    ) {}

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (string)$this->token;
    }
}
