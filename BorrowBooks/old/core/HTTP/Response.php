<?php

namespace Core\HTTP;

class Response
{
    public array $headers = [];

    public function __construct(
        public readonly int $status,
        public readonly string $reason_phrase,
        public readonly string $body = ''
    ) {}
}
