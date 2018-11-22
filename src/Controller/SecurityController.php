<?php

namespace App\Controller;

use App\Http\Message\Redirect;
use App\Http\Message\RequestInterface;
use App\Http\Message\ResponseInterface;
use App\Http\Session\SessionManagerInterface;
use App\Service\SecurityService;
use App\Storage\Entity\User;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController
{
    /** @var SecurityService */
    private $service;
    /** @var SessionManagerInterface */
    private $sessionManager;

    /**
     * SecurityController constructor.
     * @param SecurityService $service
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(SecurityService $service, SessionManagerInterface $sessionManager)
    {
        $this->service = $service;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function login(RequestInterface $request): ResponseInterface
    {
        $user = $this->service->authorize($request);
        if ($user instanceof User) {
            $this->sessionManager->set('user', $user);
        }

        return new Redirect('/');
    }

    /**
     * @return ResponseInterface
     */
    public function logout(): ResponseInterface
    {
        $this->sessionManager->destroy('user');

        return new Redirect('/');
    }
}
