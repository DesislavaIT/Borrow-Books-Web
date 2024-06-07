<?php

namespace Core\DI;

use Core\DI\Exceptions\ContainerException;
use Core\DI\Exceptions\ProviderNotFoundException;
use Core\DI\Exceptions\ResolvingException;
use Core\DI\Interfaces\ProviderInterface;

class Provider implements ProviderInterface
{
    public const DEFAULT_OPTIONS = [
        'shared' => true,
        'multi'  => false,
        'tags'   => []
    ];

    /**
     * @var Injector $injector
     */
    private Injector $injector;
    /**
     * @var mixed $instance
     */
    private mixed $instance = null;

    /**
     * @param string|InjectionToken $token
     * @param string|null $class
     * @param string|InjectionToken|null $existing
     * @param mixed|null $factory
     * @param mixed|null $value
     * @param array{ shared?: boolean, multi?: boolean, tags?: string[] } $options
     */
    public function __construct(
        private readonly string|InjectionToken $token,
        private readonly ?string $class = null,
        private readonly string|InjectionToken|null $existing = null,
        private readonly mixed $factory = null,
        private readonly mixed $value = null,
        private array $options = []
    )
    {
        $this->options = array_merge(static::DEFAULT_OPTIONS, $options);
    }

    /**
     * @return mixed
     *
     * @throws ContainerException
     * @throws ProviderNotFoundException
     * @throws ResolvingException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getInstance(): mixed
    {
        if (is_null($this->instance) or !$this->isShared()) {
            // Resolve the instance using a qualified class name.
            if (!is_null($this->class)) {
                $this->instance = $this->injector->resolve($this->class);
            }
            // Resolve the instance referencing an existing token.
            elseif (!is_null($this->existing)) {
                $this->instance = $this->injector->get($this->existing);
            }
            // Resolve the instance using a factory function.
            elseif (!is_null($this->factory)) {
                $this->instance = call_user_func_array($this->factory, [$this->injector]);
            }
            // Resolve the instance using a direct value.
            elseif (!is_null($this->value)) {
                $this->instance = $this->value;
            } else {
                throw new \Exception(
                    "Misconfigured provider for token \"{$this->token}\". " .
                    "One of \"class\", \"existing\", \"factory\" or \"value\" should be used."
                );
            }
        }

        $this->assertMatchingType();

        return $this->instance;
    }

    /**
     * @param Injector $injector
     *
     * @return static
     */
    public function setInjector(Injector $injector): static
    {
        $this->injector = $injector;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (string)$this->token;
    }

    /**
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->options['shared'];
    }

    /**
     * @return bool
     */
    public function isMulti(): bool
    {
        return $this->options['multi'];
    }

    /**
     * @param string $tag
     *
     * @return bool
     */
    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->options['tags']);
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    private function assertMatchingType(): void
    {
        if ($this->token instanceof InjectionToken and !is_null($this->token->getType())) {
            $instance_type = get_debug_type($this->instance);
            if ($instance_type !== $this->token->getType()) {
                throw new \Exception(
                    "Mismatched types. ({$this->token->getType()} expected, $instance_type given.)"
                );
            }
        }
    }
}
