<?php

namespace Bookstore\Repositories;

use Bookstore\Models\File;
use Core\Database\Repository;

class FileRepository extends Repository
{
    protected const TABLE = 'files';

    protected function initialize(): void {}

    public function create(array $data): ?File
    {
        $statement = $this->database->pdo->prepare(
            'INSERT INTO ' . static::TABLE . ' (filename, storage_path, mime_type, author, size)
                   VALUES (:filename, :storage_path, :mime_type, :author, :size)
            '
        );

        $statement->bindValue(':filename', $data['filename']);
        $statement->bindValue(':storage_path', $data['storage_path']);
        $statement->bindValue(':mime_type', $data['mime_type']);
        $statement->bindValue(':author', $data['author']);
        $statement->bindValue(':size', $data['size']);

        if ($statement->execute()) {
            return $this->findByStoragePath($data['storage_path']);
        }

        return null;
    }

    /**
     * @return File[]
     */
    public function all(): array
    {
        $query = $this->database->query(self::TABLE)->select('*');

        return array_map(function($data) {
            return $this->hydrate($data);
        }, $query->get());
    }

    public function find(int $id): ?File
    {
        $query = $this->database->query(self::TABLE)
            ->select('*')
            ->where('id = :id')
            ->setParameter(':id', $id)
        ;

        $result = $query->get()[0] ?? null;

        if ($result) {
            return $this->hydrate($result);
        }

        return null;
    }

    public function findByStoragePath(string $storage_path): ?File
    {
        $query = $this->database->query(self::TABLE)
            ->select('*')
            ->where('storage_path = :storage_path')
            ->setParameter(':storage_path', $storage_path)
        ;

        $result = $query->get()[0] ?? null;

        if ($result) {
            return $this->hydrate($result);
        }

        return null;
    }

    private function hydrate(array $data): File
    {
        return new File(
            (int)$data['id'],
            $data['filename'],
            $data['storage_path'],
            $data['mime_type'],
            $data['author'] ?? 'Unknown',
            (int)$data['size']
        );
    }
}
