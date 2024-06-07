<?php

namespace Bookstore\Classes;

use Core\HTTP\Response;
use Core\Web\Template;

class ResponseFactory
{
    public static function redirect(string $path): Response
    {
        $response = new Response(302, 'Found');

        $response->headers['Location'] = $path;

        return $response;
    }

    public static function view(string $filename, array $data = []): Response
    {
        $response = new Response(200, 'OK', Template::render($filename, $data));

        $response->headers['Content-Type'] = 'text/html';

        return $response;
    }
}
