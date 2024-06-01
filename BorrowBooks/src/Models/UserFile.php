<?php

namespace Bookstore\Models;

class UserFile
{
    public function __construct(
        private User      $user,
        private File      $file,
        private \DateTime $return_date
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getReturnDate(): \DateTime
    {
        return $this->return_date;
    }

    public function setReturnDate(\DateTime $return_date): static
    {
        $this->return_date = $return_date;

        return $this;
    }
}
