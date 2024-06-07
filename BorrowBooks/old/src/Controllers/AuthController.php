<?php

namespace Bookstore\Controllers;

use Bookstore\Classes\ResponseFactory;
use Bookstore\Repositories\UserRepository;
use Core\HTTP\Request;
use Core\HTTP\Response;
use Core\Web\Router\Route;

class AuthController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    #[Route('/login', methods: ['GET', 'POST'], name: 'auth_login')]
    public function login(Request $request): Response
    {
        if (application()->user) {
            return ResponseFactory::redirect('/home');
        }

        if ($request->method === 'POST') {
            $email    = $request->input['email'];
            $password = $request->input['password'];

            $user = $this->userRepository->findByEmail($email);
            if ($user and (password_verify($password, $user->getPassword()))) {
                $_SESSION['user_id'] = $user->getId();

                return ResponseFactory::redirect('/home');
            }

        }

        return ResponseFactory::view('views/auth/login.html.php', []);
    }

    #[Route('/register', methods: ['GET', 'POST'], name: 'auth_register')]
    public function register(Request $request): Response
    {
        if (application()->user) {
            return ResponseFactory::redirect('/home');
        }

        if ($request->method === 'POST') {
            $user = $this->userRepository->create($request->input);

            if ($user) {
                $_SESSION['user_id'] = $user->getId();

                return ResponseFactory::redirect('/home');
            }
        }

        return ResponseFactory::view('views/auth/register.html.php', []);
    }

    #[Route('/logout', methods: ['GET', 'POST'])]
    public function logout(): Response
    {
        unset($_SESSION['user_id']);
        session_unset();
        session_destroy();

        return ResponseFactory::redirect('/');
    }
}
