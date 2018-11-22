<?php

namespace App\Storage\Entity;

/**
 * Class User
 * @package App\Storage\Entity
 */
class User
{
    public const TABLE = 'users';
    public const JOIN_FIELD = 'user_id';

    /** @var int */
    private $id;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var bool */
    private $isAdmin;

    /**
     * User constructor.
     * @param string $username
     * @param int|null $id
     */
    public function __construct(string $username, int $id = null)
    {
        $this->username = $username;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password = null): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin): User
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}
