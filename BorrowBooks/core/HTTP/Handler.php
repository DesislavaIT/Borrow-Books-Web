<?php

namespace Core\HTTP;

class Handler
{
    public function getCurrentRequest(): Request
    {
        return Request::fromGlobals();
    }

    public function send(Response $response): void
    {
        $status_line = sprintf('HTTP/1.1 %s %s',
            $response->status,
            $response->reason_phrase
        );
        header($status_line, true, $response->status);

        foreach ($response->headers as $header => $value) {
            header("$header: $value");
        }

        echo $response->body;
    }
}
