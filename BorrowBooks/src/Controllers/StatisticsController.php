<?php

namespace Bookstore\Controllers;

use Core\HTTP\Response;
use Bookstore\Repositories\FileRepository;
use Core\Web\Router\Route;

class StatisticsController
{
    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    #[Route('/statistics/topBooks', methods: ['GET'])]
    public function topBooksAndReaders(): Response
    {
        $topBooksAndReaders = $this->fileRepository->getTop5MostReadBooks();
        $topBooks = array_column($topBooksAndReaders, 'title');
        $readersCount = array_column($topBooksAndReaders, 'user_count');
    
        $response = new Response(200, 'OK', json_encode(['topBooks' => $topBooks, 'readersCount' => $readersCount], JSON_UNESCAPED_UNICODE));
        $response->headers['Content-Type'] = 'application/json; charset=utf-8';
        return $response;
    }

    #[Route('/statistics/topAuthors', methods: ['GET'])]
    public function topAuthorsAndUploadedBooks(): Response
    {
        $topAuthorsAndUploads = $this->fileRepository->getTopAuthorsAndUploadedBooks();
        $topAuthors = array_column($topAuthorsAndUploads, 'author');
        $uploadCounts = array_column($topAuthorsAndUploads, 'upload_count');

        $response = new Response(200, 'OK', json_encode(['topAuthors' => $topAuthors, 'uploadCounts' => $uploadCounts], JSON_UNESCAPED_UNICODE));
        $response->headers['Content-Type'] = 'application/json; charset=utf-8';
        return $response;
    }
}
