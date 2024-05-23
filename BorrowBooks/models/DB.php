<?php

namespace models;

use PDO;
use PDOException;
use Exception;

class Database {
    private $connection;

    public function __construct() {
        $this->connection = null;
    }

    public function connect() {
        if ($this->connection === null) {
            $dbhost = "localhost";
            $dbName = "borrow_books_web";
            $userName = "root";
            $userPassword = "";

            try {
                $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbName", $userName, $userPassword);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Connection failed: " . $e->getMessage());
            }
        }

        return $this->connection;
    }

    public function disconnect() {
        $this->connection = null;
    }
}
