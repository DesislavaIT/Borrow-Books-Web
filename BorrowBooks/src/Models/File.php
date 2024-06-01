<?php

namespace Bookstore\Models;

class File
{
    public function __construct(
        public readonly int $id,
        public string       $filename,
        public string       $storage_path,
        public string       $mime_type,
        public string       $author,
        public int          $size,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getStoragePath(): string
    {
        return $this->storage_path;
    }

    public function setStoragePath(string $storage_path): static
    {
        $this->storage_path = $storage_path;

        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): static
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }
}
