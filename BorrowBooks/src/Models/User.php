<?php

namespace Bookstore\Models;

class User
{
    public const ROLE_USER  = 'user';
    public const ROLE_ADMIN = 'admin';

    public const DEFAULT_ROLES = [self::ROLE_USER];

    public function __construct(
        private readonly int $id,
        private string       $email,
        private string       $username,
        private string       $password,
        private array        $roles = self::DEFAULT_ROLES
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): static
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): static
    {
        $this->roles = array_diff($this->roles, [$role]);

        return $this;
    }
}
