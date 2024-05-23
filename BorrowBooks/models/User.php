<?php

namespace models;

class User {
    private $username;
    private $email;
    private $password_hash;
    private $is_admin;

    public function __construct($username, $email, $password_hash, $is_admin = false) {
        $this->username = $username;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->is_admin = $is_admin;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPasswordHash() {
        return $this->password_hash;
    }

    public function isAdmin() {
        return $this->is_admin;
    }
}
