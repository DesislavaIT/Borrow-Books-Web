<?php

namespace Bookstore\Models;

class UserFile
{
    public function __construct(
        private User $user,
        private File $file,
        private \DateTime $returning_date
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

    public function getReturningDate(): \DateTime
    {
        return $this->returning_date;
    }

    public function setReturningDate(\DateTime $returning_date): static
    {
        $this->returning_date = $returning_date;

        return $this;
    }
}
