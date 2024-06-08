<?php

namespace Bookstore\Repositories;

use Bookstore\Models\File;
use Bookstore\Models\User;
use Bookstore\Models\UserFile;
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

    public function borrow(int $book_id, int $user_id, \DateTime $return_date): bool
    {
        $borrowed = $this->database->query('user_files')
            ->select('*')
            ->where('book_id = :book_id')
            ->setParameter(':book_id', $book_id)
            ->get()[0] ?? null;

        if (!$borrowed) {
            $statement = $this->database->pdo->prepare('
                INSERT INTO user_files (user_id, book_id, return_date)
                VALUES (:user_id, :book_id, :return_date)
            ');

            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':book_id', $book_id);
            $statement->bindValue(':return_date', $return_date->format('Y-m-d'));

            return $statement->execute();
        }

        return false;
    }

    public function return(int $book_id, int $user_id): bool
    {
        $statement = $this->database->pdo->prepare('
            DELETE FROM user_files
            WHERE book_id = :book_id AND user_id = :user_id
        ');

        $statement->bindValue(':book_id', $book_id);
        $statement->bindValue(':user_id', $user_id);

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $statement = $this->database->pdo->prepare('DELETE FROM ' . self::TABLE . ' WHERE id = :id');
        $statement->bindValue(':id', $id);
        return $statement->execute();
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

    public function findBorrowedBy(User $user): array
    {
        $query = $this->database->query('user_files')
            ->select('*')
            ->where('user_id = :user_id')
            ->setParameter(':user_id', $user->getId())
        ;

        return array_map(function($data) use ($user) {
            return new UserFile(
                $user,
                $this->find((int)$data['book_id']),
                new \DateTime($data['return_date']),
            );
        }, $query->get());
    }

    public function checkBorrowedBy(File $file, User $user): bool
    {
        $query = $this->database->query('user_files')
            ->select('*')
            ->where('user_id = :user_id')
            ->where('book_id = :book_id')
            ->where('NOW() < return_date')
            ->setParameter(':user_id', $user->getId())
            ->setParameter(':book_id', $file->getId())
        ;

        return count($query->get()) > 0;
    }

    public function isBorrowed(int $bookId): bool
    {
        $query = $this->database->query('user_files')
            ->select('*')
            ->where('book_id = :book_id')
            ->setParameter(':book_id', $bookId);
    
        return count($query->get()) > 0;
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
