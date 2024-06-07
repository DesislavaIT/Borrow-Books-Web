<?php

namespace Core\DI\Attributes;

use Core\DI\Interfaces\InjectionTokenInterface;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Injectable
{
    /**
     * @param string|InjectionTokenInterface|null $provides
     * @param string|null $aliasing
     * @param bool $shared
     * @param bool $multi
     * @param string[] $tags
     */
    public function __construct(
        private readonly string|InjectionTokenInterface|null $provides = null,
        private readonly ?string $aliasing = null,
        private readonly bool $shared = true,
        private readonly bool $multi = false,
        private readonly array $tags = []
    ) {}

    /**
     * @return string|InjectionTokenInterface|null
     */
    public function getProvides(): string|InjectionTokenInterface|null
    {
        return $this->provides;
    }

    /**
     * @return string|null
     */
    public function getAliasing(): ?string
    {
        return $this->aliasing;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * @return bool
     */
    public function isMulti(): bool
    {
        return $this->multi;
    }
}
