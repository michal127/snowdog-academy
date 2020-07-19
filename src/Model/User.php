<?php

namespace Snowdog\Academy\Model;

class User
{
    public const BIRTHDAY_FORMAT = 'Y-m-d';
    private const ADULT_AGE = 18;

    public int $id;
    public string $login;
    public string $password;
    public bool $is_admin;
    public bool $is_active;
    public ?string $birthdate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPasswordHash(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return (bool)$this->is_admin;
    }

    public function isActive(): bool
    {
        return (bool)$this->is_active;
    }

    public function getBirthdate(): string
    {
        return $this->birthdate ?: '-';
    }

    public function isAdult(): bool
    {
        if (!$this->birthdate) {
            return true;
        }
        return $this->birthdate < date(self::BIRTHDAY_FORMAT, strtotime('-' . self::ADULT_AGE . ' years'));
    }
}
