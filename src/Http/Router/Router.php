<?php

namespace App\Http\Router;

use App\Exception\InvalidArgumentException;
use App\Exception\InvalidRequestMethodException;
use App\Exception\MethodNotAllowedException;
use App\Exception\RouteNotFoundException;
use App\Http\Message\RequestInterface;

/**
 * Class Router - maps Request URI to the Controllers
 * @package App\Router
 */
class Router implements RouterInterface
{
    /** @var array */
    private $validMethods;
    /** @var RouteInterface[] */
    private $routes;

    /**
     * Router constructor.
     * @param array $validMethods
     */
    public function __construct(array $validMethods = ['GET', 'POST'])
    {
        $this->validMethods = $validMethods;
    }

    /**
     * @inheritdoc
     */
    public function resolve(RequestInterface $request): RouteInterface
    {
        $this->validateRequestMethod($request->getRequestMethod());

        return $this->match($request);
    }

    /**
     * @inheritdoc
     */
    public function add(string $route, string $requestMethod, string $controller, string $controllerMethod): RouterInterface
    {
        $this->validateRequestMethod($requestMethod);
        $this->validateController($controller, $controllerMethod);
        $this->routes[$route] = new Route($route, $requestMethod, $controller, $controllerMethod);

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return RouteInterface
     */
    private function match(RequestInterface $request): RouteInterface
    {
        $route = $request->getRoute();
        if (!isset($this->routes[$route])) {
            throw new RouteNotFoundException(sprintf('Route %s does not found', $route));
        }

        $definedRoute = $this->routes[$route];
        // Throw Exception if Defined Route Method is not the same as in the Request
        if ($definedRoute->getRequestMethod() !== $request->getRequestMethod()) {
            throw new MethodNotAllowedException(
                sprintf('Method %s Not Allowed for the Route "%s"', $request->getRequestMethod(), $route)
            );
        }

        return $this->routes[$route];
    }

    /**
     * @param string $controller
     * @param string $controllerMethod
     */
    private function validateController(string $controller, string $controllerMethod): void
    {
        if (!class_exists($controller)) {
            throw new InvalidArgumentException(
                sprintf('The provided controller class %s does not exists', $controller)
            );
        }

        if (!method_exists($controller, $controllerMethod)) {
            throw new InvalidArgumentException(
                sprintf('The provided controller class method %s does not exists', $controllerMethod)
            );
        }
    }

    /**
     * @param $method
     */
    private function validateRequestMethod($method): void
    {
        if (!\in_array($method, $this->validMethods, true)) {
            throw new InvalidRequestMethodException(
                sprintf('Invalid Request Method %s has been provided', $method)
            );
        }
    }
}
