<?php

namespace Core\DI;

use Core\DI\Attributes\Inject;
use Core\DI\Exceptions\ContainerException;
use Core\DI\Exceptions\ProviderNotFoundException;
use Core\DI\Exceptions\ResolvingException;
use Core\DI\Interfaces\CallableInvokerInterface;
use Core\DI\Interfaces\ConcreteResolverInterface;
use Core\DI\Interfaces\ContainerInterface;
use Core\DI\Interfaces\InjectionTokenInterface;

class Injector implements ContainerInterface, ConcreteResolverInterface, CallableInvokerInterface
{
    /**
     * @var Injector|null $root
     */
    private static ?Injector $root = null;

    /**
     * @var Provider[] $providers A list of available providers in this container.
     */
    private array $providers;

    /**
     * @var array<string, Provider[]> $index An associative array of token => providers for quick searching.
     */
    private array $index;

    /**
     * @return static
     */
    public static function root(): static
    {
        if (is_null(static::$root)) {
            static::$root = new Injector([]);
        }

        return static::$root;
    }

    /**
     * @param array $providers
     */
    public function __construct(array $providers) {
        $this->providers = $providers;
        array_walk($this->providers, function(Provider $provider) {
            $this->setupProvider($provider);
        });

        $this->registerSelf();

        if (is_null(static::$root)) {
            static::$root = $this;
        }
    }

    /**
     * @template T of mixed
     *
     * @param string|class-string<T>|InjectionTokenInterface<T> $token
     *
     * @return T
     *
     * @throws ContainerException
     * @throws ProviderNotFoundException
     * @throws ResolvingException
     * @throws \ReflectionException
     */
    public function get(InjectionTokenInterface|string $token): mixed
    {
        if ($this->has($token)) {
            $available = $this->index[(string)$token];
        } elseif (is_string($token)) {
            $this->setupProvider($token);
            $available = $this->index[$token];
        } else {
            throw new ProviderNotFoundException("No providers found for token \"$token\".");
        }

        if (count($available) === 1 or !$available[0]->isMulti()) {
            return $available[0]->getInstance();
        }

        if ($token instanceof InjectionToken and $token->getTagged() !== null) {
            $available = array_filter($available, function(Provider $provider) use ($token) {
                return $provider->hasTag($token->getTagged());
            });
        }

        return array_map(function(Provider $provider) {
            return $provider->getInstance();
        }, $available);
    }

    /**
     * @param string|InjectionTokenInterface $token
     *
     * @return bool
     */
    public function has(InjectionTokenInterface|string $token): bool
    {
        $token = (string)$token;

        return (isset($this->index[$token]) && !empty($this->index[$token]));
    }

    /**
     *
     * @param string $token
     * @param array $parameters
     * @return mixed
     *
     * @throws ContainerException
     * @throws ProviderNotFoundException
     * @throws ResolvingException
     * @throws \ReflectionException
     */
    public function resolve(string $token, array $parameters = []): mixed
    {
        try {
            $reflection = new \ReflectionClass($token);
        } catch (\ReflectionException $exception) {
            throw new ResolvingException("Cannot resolve concrete class \"$token\".", previous: $exception);
        }

        if ($reflection->isInterface()) {
            throw new ContainerException("Invalid provider \"$token\". (Interface providers need configuration.)");
        } elseif ($reflection->isAbstract()) {
            throw new ContainerException("Invalid provider \"$token\". (Abstract class cannot be instantiated.)");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() === 0) {
            return $reflection->newInstance();
        }

        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            $attributes = $parameter->getAttributes(Inject::class);
            if (!empty($attributes)) {
                /** @var Inject $attribute */
                $attribute = $attributes[0]->newInstance();
                $token = $attribute->getToken();
                $arguments[] = $this->get($token);
                continue;
            }

            if (($type = $parameter->getType()) and !$type->isBuiltin()) {
                $arguments[] = $this->get($type->getName());
            }
        }

        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * @throws ContainerException
     * @throws ProviderNotFoundException
     * @throws ResolvingException
     * @throws \ReflectionException
     */
    // TODO: Still not finished.
    public function invoke(mixed $callable, array $parameters = []): mixed
    {
        if ($callable instanceof \Closure) {
            $class = null;
            $reflection = new \ReflectionFunction($callable);
        } elseif (is_string($callable)) {
            $segments = explode('::', $callable);
            if (count($segments) > 1) {
                $class = $this->get($segments[0]);
                $reflection = new \ReflectionMethod($class, $segments[1]);
            } elseif (function_exists($callable)) {
                $class = null;
                $reflection = new \ReflectionFunction($callable);
            } else {
                $class = $this->get($callable);
                $reflection = new \ReflectionMethod($class, '__invoke');
            }
        } elseif (!is_array($callable)) {
            $class = $this->get($callable);
            $reflection = new \ReflectionMethod($class, '__invoke');
        } else {
            $class = $this->get($callable[0]);
            $reflection = new \ReflectionMethod($class, $callable[1]);
        }

        if ($reflection instanceof \ReflectionFunction) {
            $reflection->invoke(...$parameters);
        } else {
            $reflection->invoke($class, $parameters);
        }


        return null;
    }

    /**
     * @param mixed $provider
     *
     * @return void
     */
    private function setupProvider(mixed $provider): void
    {
        if ($provider instanceof Provider) {
            $provider->setInjector($this);
        } elseif (is_string($provider)) {
            $provider = new Provider($provider, $provider);
            $provider->setInjector($this);
            $this->providers[] = $provider;
        }

        if (!isset($this->index[$provider->getToken()])) {
            $this->index[$provider->getToken()] = [];
        }
        $this->index[$provider->getToken()][] = $provider;
    }

    /**
     * @return void
     */
    private function registerSelf(): void
    {
        $this->setupProvider(new Provider(static::class,                    value: $this));
        $this->setupProvider(new Provider(ContainerInterface::class,        existing: static::class));
        $this->setupProvider(new Provider(ConcreteResolverInterface::class, existing: static::class));
        $this->setupProvider(new Provider(CONTAINER,                        existing: static::class));
        $this->setupProvider(new Provider(INJECTOR,                         existing: static::class));
        $this->setupProvider(new Provider('container',                      existing: static::class));
        $this->setupProvider(new Provider('injector',                       existing: static::class));
    }
}
