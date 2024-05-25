<?php

namespace repositories;

use models\User;
use PDO;

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../models/User.php';

class UsersRepository extends Repository {

    public function __construct() {
        parent::__construct('users');
    }

    public function getByEmail($email) {
        $query = $this->database->connect()->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? new User($result['username'], $result['email'], $result['password_hash'], $result['is_admin']) : null;
    }

    public function getByUsername($username) {
        $query = $this->database->connect()->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? new User($result['username'], $result['email'], $result['password_hash'], $result['is_admin']) : null;
    }

    public function create(User $user) {
        $query = $this->database->connect()->prepare(
            "INSERT INTO users (username, email, password_hash, is_admin) VALUES (:username, :email, :password_hash, :is_admin)"
        );
        $query->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);
        $query->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $query->bindParam(':password_hash', $user->getPasswordHash(), PDO::PARAM_STR);
        $query->bindParam(':is_admin', $user->isAdmin(), PDO::PARAM_BOOL);
        return $query->execute();
    }
}
