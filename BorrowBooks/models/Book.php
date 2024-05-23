<?php

namespace models;

class Book {
    private $title;
    private $author;
    private $imageUrl;
    private $published_date;
    private $summary;
    private $isbn;

    public function __construct($title, $author, $imageUrl, $published_date, $summary, $isbn) {
        $this->title = $title;
        $this->author = $author;
        $this->imageUrl = $imageUrl;
        $this->published_date = $published_date;
        $this->summary = $summary;
        $this->isbn = $isbn;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getImageUrl() {
        return $this->imageUrl;
    }

    public function getPublishedDate() {
        return $this->published_date;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getIsbn() {
        return $this->isbn;
    }
}