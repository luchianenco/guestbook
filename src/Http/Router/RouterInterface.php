<?php

namespace App\Http\Router;

use App\Http\Message\RequestInterface;

/**
 * Interface RouterInterface
 * @package App\Http\Router
 */
interface RouterInterface
{
    /**
     * @param RequestInterface $request
     * @return RouteInterface
     */
    public function resolve(RequestInterface $request): RouteInterface;

    /**
     * @param string $route
     * @param string $requestMethod
     * @param string $controller
     * @param string $controllerMethod
     * @return RouterInterface
     */
    public function add(string $route, string $requestMethod, string $controller, string $controllerMethod): RouterInterface;
}
