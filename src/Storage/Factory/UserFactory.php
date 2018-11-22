<?php

namespace App\Storage\Factory;

use Generator;
use App\Storage\Entity\User;
use App\Exception\InvalidArgumentException;

/**
 * Class UserFactory
 * @package App\Storage\Factory
 */
class UserFactory
{
    /**
     * @param \Generator $generator
     * @return User|null
     */
    public function create(Generator $generator): ?User
    {
        if (!$generator->current()) {
            return null;
        }
        return $this->createFromArray($generator->current());
    }

    /**
     * @param array $row
     * @return User
     */
    public function createFromArray(array $row): User
    {
        $this->validate($row);
        $isAdmin = $row['is_admin'] ?? false;

        $user = new User($row['username'], $row['id']);
        $user
            ->setIsAdmin($isAdmin)
            ->setPassword($row['password'])
        ;

        return $user;
    }

    /**
     * @param array $row
     */
    private function validate(array $row): void
    {
        if (!isset($row['username']) && !\is_string($row['username'])) {
            throw new InvalidArgumentException('Invalid username provided');
        }

        if (isset($row['id']) && !filter_var($row['id'], FILTER_VALIDATE_INT)) {
            throw new InvalidArgumentException('User ID cannot be non integer');
        }
    }
}
