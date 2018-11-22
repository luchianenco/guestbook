<?php

namespace App;

use Throwable;
use App\Exception\MethodNotAllowedException;
use App\Exception\RouteNotFoundException;
use App\Http\Message\RequestInterface;
use App\Http\Message\Response;
use App\Http\Message\ResponseInterface;
use App\Http\Router\RouteInterface;
use App\Http\Router\Router;
use App\Http\Router\RouterInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Application
 * @package App
 */
class Application
{
    /** @var ContainerInterface  */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        /** @var Router $router */
        $router = $this->container->get(RouterInterface::class);

        // Get Route Based on Request
        try {
            $route = $router->resolve($request);
        } catch (MethodNotAllowedException $e) {
            return new Response(405);
        } catch (RouteNotFoundException $e) {
            return new Response(404);
        }

        try {
            return $this->executeController($route, $request);
        } catch (Throwable $e) {
            return new Response(500);
        }
    }

    /**
     * @param RouteInterface $route
     * @param RequestInterface $request
     * @return mixed
     * @throws \ReflectionException
     */
    private function executeController(RouteInterface $route, RequestInterface $request): ResponseInterface
    {
        // Execute Controller defined in the Route
        $controllerName = $route->getController();
        $methodName = $route->getControllerMethod();
        $hasRequestParam = $this->hasRequestInterfaceParameter($controllerName, $methodName);
        // Get Controller from Container
        $controller = $this->container->get($controllerName);

        if ($hasRequestParam) {
            return $controller->{$methodName}($request);
        }

        return $controller->{$methodName}();
    }

    /**
     * @param string $controllerName
     * @param string $methodName
     * @return bool
     * @throws \ReflectionException
     */
    private function hasRequestInterfaceParameter(string $controllerName, string $methodName): bool
    {
        $reflector = new \ReflectionMethod($controllerName, $methodName);
        $params = $reflector->getParameters();

        // No Parameters
        if (!\count($params)) {
            return false;
        }

        // Loop through the Parameters, if RequestInterface set as parameter return true
        foreach ($params as $param) {
            if (RequestInterface::class === $param->getClass()->getName()) {
                return true;
            }
        }
        return false;
    }
}
