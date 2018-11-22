<?php

namespace App\Storage\Repository;

use App\Storage\Entity\User;
use App\Storage\Factory\UserFactory;
use App\Storage\AdapterInterface;
use App\Storage\Query\Query;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository
{
    /** @var AdapterInterface */
    private $storage;
    /** @var UserFactory */
    private $factory;

    /**
     * UserRepository constructor.
     * @param AdapterInterface $adapter
     * @param UserFactory $factory
     */
    public function __construct(AdapterInterface $adapter, UserFactory $factory)
    {
        $this->storage = $adapter;
        $this->factory = $factory;
    }

    /**
     * @param string $login
     * @param string $password
     * @return User|null
     */
    public function findByLoginPassword(string $login, string $password): ?User
    {
        $query = new Query();
        $query->setWhere([
            'username' => $login,
            'password' => $password
        ]);

        return $this->find($query);
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function findByUsername(string $login): ?User
    {
        $query = new Query();
        $query->setWhere(['username' => $login]);

        return $this->find($query);
    }

    /**
     * @param string $id
     * @return User|null
     */
    public function findById(string $id): User
    {
        $query = new Query();
        $query->setWhere(['id' => $id]);

        return $this->find($query);
    }

    /**
     * @param Query $query
     * @return User|null
     */
    public function find(Query $query): ?User
    {
        $query->setTable(User::TABLE);
        $row = $this->storage->select($query);

        return $this->factory->create($row);
    }
}
