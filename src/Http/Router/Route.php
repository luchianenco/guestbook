<?php

namespace App\Http\Router;

/**
 * Class Route
 * @package App\Http\Router
 */
class Route implements RouteInterface
{
    /** @var string */
    private $route;
    /** @var string */
    private $requestMethod;
    /** @var string */
    private $controller;
    /** @var string */
    private $controllerMethod;

    /**
     * Route constructor.
     * @param string $route
     * @param string $method
     * @param string $controller
     * @param string $controllerMethod
     */
    public function __construct(string $route, string $method, string $controller, string $controllerMethod)
    {
        $this->route = $route;
        $this->requestMethod = $method;
        $this->controller = $controller;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }
}
