<?php

namespace Core\HTTP;

class Request
{
    public readonly array $input;
    public readonly array $query;
    public readonly array $files;

    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $headers = [],
        public readonly string $body = ''
    ) {}

    public static function fromGlobals(): static
    {
        $method  = strtoupper($_SERVER['REQUEST_METHOD']);
        $path    = explode('?', $_SERVER['REQUEST_URI'])[0];
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
            }
        }

        $request = new static($method, $path, $headers);
        $request->parse();

        return $request;
    }

    private function parse(): void
    {
        $this->input = $_POST;
        $this->query = $_GET;
        $this->files = $_FILES;
    }
}
