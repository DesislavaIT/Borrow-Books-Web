<?php

namespace Core\DI\Interfaces;

interface ProviderLoaderInterface
{
    /**
     * @return void
     */
    public function load(): void;

    /**
     * @return ProviderInterface[]
     */
    public function getProviders(): array;
}
