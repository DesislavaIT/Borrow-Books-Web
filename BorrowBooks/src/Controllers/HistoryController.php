<?php

namespace Bookstore\Controllers;

use Core\HTTP\Response;
use Bookstore\Repositories\FileRepository;
use Core\Web\Router\Route;

class HistoryController
{
    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    #[Route('/history/allBooks', methods: ['GET'])]
    public function userHistory(): Response
    {
        $currentUser = application()->user;
        
        $booksInHistory = $this->fileRepository->getAllInHistory($currentUser);

        $books = array_map(function ($userHistory) {
            return [
                'title' => $userHistory->getFile()->getFilename(),
                'author' => $userHistory->getFile()->getAuthor()
            ];
        }, $booksInHistory);

        $response = new Response(200, 'OK', json_encode(['booksInHistory' => $books], JSON_UNESCAPED_UNICODE));
        $response->headers['Content-Type'] = 'application/json; charset=utf-8';

        return $response;
    }
}
