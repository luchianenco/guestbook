<?php

namespace App\Service;

use App\Exception\InvalidArgumentException;
use App\Http\Message\RequestInterface;
use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;

/**
 * Class SecurityService
 * @package App\Service
 */
class SecurityService
{
    /** @var UserRepository */
    private $repository;

    /**
     * SecurityService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RequestInterface $request
     * @return User|null
     */
    public function authorize(RequestInterface $request): ?User
    {
        $isValid = $this->isValidForm($request);
        if (!$isValid) {
            throw new InvalidArgumentException('Invalid Login Form');
        }
        $username = $request->get('username');
        $user = $this->repository->findByUsername($username);
        if (!$user instanceof User) {
            return null;
        }

        if (password_verify($request->get('password'), $user->getPassword())) {
            return $user;
        }

        return null;
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    private function isValidForm(RequestInterface $request): bool
    {
        return $request->get('username') && $request->get('password');
    }
}
