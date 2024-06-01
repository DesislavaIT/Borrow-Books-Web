<?php

namespace Bookstore\Controllers;

use Bookstore\Repositories\FileRepository;
use Core\HTTP\Request;
use Core\HTTP\Response;
use Core\Web\Router\Route;

class ImportController
{
    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    #[Route('/import', methods: ['POST'])]
    public function import(Request $request): Response
    {
        if (!application()->user) {
            $response                          = new Response(401, 'Unauthorized',
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

        for ($i = 0; $i < count($request->files['resource']['error']); $i++) {
            if ($request->files['resource']['error'][$i] === UPLOAD_ERR_OK) {
                $filename     = bin2hex(random_bytes(16));
                $storage_path = DIR_ROOT . '/storage/uploads/' . $filename;

                move_uploaded_file($request->files['resource']['tmp_name'][$i], $storage_path);

                $this->fileRepository->create([
                    'filename'     => $request->files['resource']['name'][$i],
                    'storage_path' => '/storage/uploads/' . $filename,
                    'mime_type'    => $request->files['resource']['type'][$i],
                    'author'       => application()->user->getUsername(),
                    'size'         => (int)$request->files['resource']['size'][$i]
                ]);
            }
        }

        $response                          = new Response(200, 'OK',
            json_encode([
                'status'  => 200,
                'message' => ''
            ])
        );
        $response->headers['Content-Type'] = 'application/json';

        return $response;
    }
}
