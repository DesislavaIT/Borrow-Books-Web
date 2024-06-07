<?php

namespace Core\DI;

use Core\DI\Interfaces\ProviderInterface;
use Core\DI\Interfaces\ProviderLoaderInterface;

class InjectorBuilder
{
    /**
     * @return InjectorBuilder
     */
    public static function make(): InjectorBuilder
    {
        return new static();
    }

    /**
     * @param ProviderLoaderInterface[] $loaders
     * @param ProviderInterface[] $providers
     */
    public function __construct(
        private array $loaders = [],
        private array $providers = []
    ) {}

    /**
     * @param ProviderLoaderInterface $loader
     *
     * @return static
     */
    public function addLoader(ProviderLoaderInterface $loader): static
    {
        $this->loaders[] = $loader;

        return $this;
    }

    /**
     * @param class-string|ProviderInterface $provider
     *
     * @return static
     */
    public function addProvider(string|ProviderInterface $provider): static
    {
        if (is_string($provider)) {
            $provider = new Provider($provider, $provider);
        }

        $this->providers[] = $provider;

        return $this;
    }

    /**
     * @return Injector
     */
    public function build(): Injector
    {
        $providers = $this->providers;

        foreach ($this->loaders as $loader) {
            $loader->load();
            $providers = array_merge($providers, $loader->getProviders());
        }

        return new Injector($providers);
    }
}
