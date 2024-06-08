<?php

namespace Bookstore\Controllers;

use Bookstore\Repositories\FileRepository;
use Core\HTTP\Request;
use Core\HTTP\Response;
use Core\Web\Router\Route;

class BookController
{
    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    #[Route('/book/{id}/borrow', methods: ['POST'])]
    public function borrow(Request $request, array $params): Response
    {
        if ($response = $this->checkUserValidity()) {
            return $response;
        }

        $return_date = (new \DateTime('now'))->modify('+20 days');

        if ($this->fileRepository->borrow((int)$params["id"], application()->user->getId(), $return_date)) {
            $response = new Response(200, 'OK',
                json_encode([
                    'status'  => 200,
                    'message' => ''
                ])
            );
        } else {
            $response = new Response(406, 'Not Acceptable',
                json_encode([
                    'status'  => 406,
                    'message' => 'Not Acceptable',
                    'error'   => [
                        'message' => 'You cannot borrow this resource anymore.'
                    ]
                ])
            );
        }

        $response->headers['Content-Type'] = 'application/json';

        return $response;
    }

    #[Route('/book/{id}/read')]
    public function read(Request $request, array $params): Response
    {
        if ($response = $this->checkUserValidity()) {
            return $response;
        }

        $file = $this->fileRepository->find((int)$params['id']);
        if ($file and $this->fileRepository->checkBorrowedBy($file, application()->user)) {
            $body = file_get_contents(DIR_ROOT . $file->getStoragePath());

            $response = new Response(200, 'OK', $body);
            $response->headers['Content-Type']   = $file->getMimeType();
            $response->headers['Content-Length'] = $file->getSize();

            return $response;
        }

        return new Response(404, 'Not Found', '
            <h1>Oops!</h1>
            <p>The resource you\'re trying to read is not available either because it was removed or the returning date passed.</p>
        ');
    }

    #[Route('/book/{id}/return', methods: ['POST'])]
    public function return(Request $request, array $params): Response
    {
        if ($response = $this->checkUserValidity()) {
            return $response;
        }

        if ($this->fileRepository->return((int)$params["id"], application()->user->getId())) {
            $response = new Response(200, 'OK',
                json_encode([
                    'status'  => 200,
                    'message' => 'Book returned successfully.'
                ])
            );
        } else {
            $response = new Response(406, 'Not Acceptable',
                json_encode([
                    'status'  => 406,
                    'message' => 'Not Acceptable',
                    'error'   => [
                        'message' => 'You cannot return this book.'
                    ]
                ])
            );
        }

        $response->headers['Content-Type'] = 'application/json';

        return $response;
    }

    #[Route('/book/{id}/delete', methods: ['DELETE'])]
    public function delete(Request $request, array $params): Response
    {
        if ($response = $this->checkUserValidity()) {
            return $response;
        }
    
        $file = $this->fileRepository->find((int)$params['id']);
        if ($file && $file->getAuthor() === application()->user->getUsername()) {
            if ($this->fileRepository->isBorrowed($file->getId())) {
                return new Response(403, 'Forbidden', json_encode(['status' => 403, 'message' => 'The book is currently borrowed and cannot be deleted.']));
            }
    
            $this->fileRepository->delete((int)$params['id']);
            return new Response(200, 'OK', json_encode(['status' => 200, 'message' => 'Book deleted successfully.']));
        }
    
        return new Response(403, 'Forbidden', json_encode(['status' => 403, 'message' => 'You are not authorized to delete this book.']));
    }

    private function checkUserValidity(): ?Response
    {
        if (!application()->user) {
            $response = new Response(401, 'Unauthorized',
                json_encode([
                    'status'  => 401,
                    'message' => 'Unauthorized',
                    'error'   => [
                        'message' => 'You are not authorized to preform this action.',
                    ]
                ])
            );

            $response->headers['Content-Type'] = 'application/json';

            return $response;
        }

        return null;
    }
}
