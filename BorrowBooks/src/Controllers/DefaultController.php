<?php

namespace Bookstore\Controllers;

use Bookstore\Classes\ResponseFactory;
use Bookstore\Repositories\FileRepository;
use Core\HTTP\Response;
use Core\Web\Router;
use Core\Web\Router\Route;

class DefaultController
{
    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    #[Route('/')]
    public function index(): Response
    {
        if (application()->user) {
            return ResponseFactory::redirect('/home');
        }

        return ResponseFactory::redirect('/login');
    }

    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        if (!application()->user) {
            return ResponseFactory::redirect('/login');
        }

        return ResponseFactory::view('views/home/index.html.php', [
            'books' => $this->fileRepository->all()
        ]);
    }

    #[Route('/borrowed', name: 'borrowed')]
    public function borrowed(): Response
    {
        return ResponseFactory::view('views/borrowed/index.html.php', [
            'books' => $this->fileRepository->findBorrowedBy(application()->user)
        ]);
    }

    #[Route('/statistics', name: 'statistics')]
    public function statistics(): Response
    {
        return ResponseFactory::view('views/statistics/index.html.php', [
            'books' => $this->fileRepository->all()
        ]);
    }

    #[Route('/history', name: 'history')]
    public function history(): Response
    {
        return ResponseFactory::view('views/history/index.html.php', [
            'books' => $this->fileRepository->getAllInHistory(application()->user)
        ]);
    }
}
