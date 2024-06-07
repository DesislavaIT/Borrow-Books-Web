<?php

namespace Bookstore\Classes;

use Bookstore\Models\User;
use Bookstore\Repositories\UserRepository;
use Core\DI\Attributes\Inject;
use Core\HTTP\Handler;
use Core\HTTP\Response;
use Core\Web\Router;

class Application
{
    public ?User $user = null;

    public function __construct(
        public readonly Handler                  $http,
        #[Inject(ROUTER)] public readonly Router $router
    ) {}

    public function run(): void
    {
        $request = $this->http->getCurrentRequest();

        session_start();

        $this->authenticate();

        $response = $this->router->resolve($request);

        if (is_string($response)) {
            $response = new Response(200, 'OK', $response);
        } elseif (!($response instanceof Response)) {
            $response = new Response(500, 'Internal Server Error', '<h1>Request could not be handled.</h1>');
        }

        $this->http->send($response);
    }

    private function authenticate(): void
    {
        $user_id = $_SESSION['user_id'] ?? null;

        if ($user_id) {
            $this->user = inject(UserRepository::class)->find((int)$user_id);
        }
    }
}
