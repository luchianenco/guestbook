<?php

namespace App\Tests\Unit\Controller;

use App\Controller\SecurityController;
use App\Http\Message\Redirect;
use App\Http\Message\RequestInterface;
use App\Http\Session\SessionManagerInterface;
use App\Service\SecurityService;
use App\Storage\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class SecurityControllerTest
 * @package App\Tests\Unit\Controller
 */
class SecurityControllerTest extends TestCase
{
    /** @var SecurityController */
    private $controller;
    /** @var SecurityService */
    private $service;
    /** @var SessionManagerInterface */
    private $session;

    public function setUp()
    {
        $this->service = $this->createMock(SecurityService::class);
        $this->session = $this->createMock(SessionManagerInterface::class);

        $this->controller = new SecurityController($this->service, $this->session);
    }

    public function testLoginSuccess(): void
    {
        $user = $this->createMock(User::class);
        $request = $this->createMock(RequestInterface::class);
        $this->service->expects($this->once())->method('authorize')->with($request)->willReturn($user);
        $this->session->expects($this->once())->method('set')->with('user', $user);

        $response = $this->controller->login($request);

        $this->assertInstanceOf(Redirect::class, $response);
    }

    public function testLoginFail(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $this->service->expects($this->once())->method('authorize')->with($request)->willReturn(null);
        $this->session->expects($this->never())->method('set');

        $response = $this->controller->login($request);

        $this->assertInstanceOf(Redirect::class, $response);
    }

    public function testLogout(): void
    {
        $this->session->expects($this->once())->method('destroy')->with('user');

        $response = $this->controller->logout();

        $this->assertInstanceOf(Redirect::class, $response);
    }
}