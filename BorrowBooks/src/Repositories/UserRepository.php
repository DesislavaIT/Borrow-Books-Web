<?php

namespace Bookstore\Repositories;

use Bookstore\Models\User;
use Core\Database\Repository;

class UserRepository extends Repository
{
    protected const TABLE = 'users';

    protected function initialize(): void {}

    public function create(array $data): ?User
    {
        $existing = $this->findByEmail($data['email']);

        if ($existing) return null;

        $data['roles'] = $data['roles'] ?? User::DEFAULT_ROLES;

        $statement = $this->database->pdo->prepare(
            'INSERT INTO ' . static::TABLE . ' (email, username, password, roles)
                   VALUES (:email, :username, :password, :roles)
            '
        );

        $statement->bindValue(':email', $data['email']);
        $statement->bindValue(':username', $data['username']);
        $statement->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':roles', json_encode($data['roles']));

        if ($statement->execute()) {
            return $this->findByEmail($data['email']);
        }

        return null;
    }

    public function find(int $id): ?User
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

    public function findByEmail(string $email): ?User
    {
        $query = $this->database->query(self::TABLE)
            ->select('*')
            ->where('email = :email')
            ->setParameter(':email', $email)
        ;

        $result = $query->get()[0] ?? null;

        if ($result) {
            return $this->hydrate($result);
        }

        return null;
    }

    private function hydrate(array $data): User
    {
        return new User(
            (int)$data['id'],
            $data['email'],
            $data['username'],
            $data['password'],
            json_decode($data['roles'] ?? '[]', true)
        );
    }
}
