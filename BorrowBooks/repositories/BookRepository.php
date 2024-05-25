<?php

namespace repositories;

use models\Book;
use PDO;

require_once __DIR__ . '/BaseRepository.php';
require_once __DIR__ . '/../models/Book.php';

class BookRepository extends Repository {

    public function __construct() {
        parent::__construct('books');
    }

    public function getByTitle($title) {
        $query = $this->database->connect()->prepare("SELECT * FROM books WHERE title = :title");
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return new Book(
                $row["title"],
                $row["author"],
                $row["imageUrl"],
                $row["published_date"],
                $row["summary"],
                $row["isbn"]
            );
        }, $result);
    }

    public function create(Book $book) {
        $query = $this->database->connect()->prepare(
            "INSERT INTO books (title, author, imageUrl, published_date, summary, isbn) VALUES (:title, :author, :imageUrl, :published_date, :summary, :isbn)"
        );
        $query->bindParam(':title', $book->getTitle(), PDO::PARAM_STR);
        $query->bindParam(':author', $book->getAuthor(), PDO::PARAM_STR);
        $query->bindParam(':imageUrl', $book->getImageUrl(), PDO::PARAM_STR);
        $query->bindParam(':published_date', $book->getPublishedDate(), PDO::PARAM_STR);
        $query->bindParam(':summary', $book->getSummary(), PDO::PARAM_STR);
        $query->bindParam(':isbn', $book->getIsbn(), PDO::PARAM_STR);
        
        return $query->execute();
    }
}
