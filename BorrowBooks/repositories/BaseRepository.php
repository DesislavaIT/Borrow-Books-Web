<?php

namespace repositories;

require __DIR__ . '/../models/DB.php';
require __DIR__ . '/../models/User.php';
require __DIR__ . '/../models/Book.php';

use models\Database;

class Repository {
    protected $database;
    protected $tableName;

    public function __construct($tableName) {
        $this->database = new Database();
        $this->tableName = $tableName;
    }

    public function __destruct() {
        $this->database->disconnect();
    }

    public function getAll() {
        $command = 'SELECT * FROM ' . $this->tableName;
        $query = $this->database->connect()->prepare($command);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filter($data, $operator = "AND") {
        $columns = array_keys($data);
        $placeholders = array_map(function($value) {
            return "$value = ?";
        }, $columns);

        $valuesPlaceholders = implode(" $operator ", $placeholders);

        $command = "SELECT * FROM $this->tableName WHERE $valuesPlaceholders";
        $query = $this->database->connect()->prepare($command);

        $index = 1;
        foreach ($data as $value) {
            $query->bindValue($index++, $value);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        $valuesPlaceholders = implode(", ", $placeholders);
        $columnsAsString = implode(", ", $columns);
        $command = "INSERT INTO $this->tableName ($columnsAsString) VALUES ($valuesPlaceholders)";
        $query = $this->database->connect()->prepare($command);

        $index = 1;
        foreach ($data as $value) {
            $query->bindValue($index++, $value);
        }

        return $query->execute();
    }
}