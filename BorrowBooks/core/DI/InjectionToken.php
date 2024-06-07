<?php

namespace Core\DI;

use Core\DI\Interfaces\InjectionTokenInterface;

class InjectionToken implements InjectionTokenInterface
{
    /**
     * @param string $identity
     * @param string|null $type
     * @param string|null $tagged
     */
    public function __construct(
        private readonly string $identity,
        private readonly ?string $type = null,
        private readonly ?string $tagged = null
    ) {}

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getTagged(): ?string
    {
        return $this->tagged;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "INJECTION_TOKEN({$this->identity})";
    }
}
