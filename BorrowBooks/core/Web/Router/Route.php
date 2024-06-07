<?php

namespace Core\Web\Router;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    private mixed $action = null;

    public function __construct(
        public readonly string $path,
        public readonly array $methods = ['GET'],
        public readonly string $name = ''
    ) {}

    public function getAction(): mixed
    {
        return $this->action;
    }

    public function setAction(mixed $action): static
    {
        $this->action = $action;

        return $this;
    }
}
