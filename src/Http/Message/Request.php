<?php

namespace App\Http\Message;

/**
 * Class Request
 * @package App\Http\Message
 */
class Request implements RequestInterface
{
    public const GET = 'GET';
    public const POST = 'POST';

    /** @var string */
    private $requestMethod;
    /** @var string */
    private $route;
    /** @var array */
    private $params;

    /**
     * Request constructor.
     * @param string $requestMethod
     * @param string $route
     * @param array $params
     */
    public function __construct(string $requestMethod, string $route, array $params)
    {
        $this->requestMethod = $requestMethod;
        $this->route = $route;
        $this->params = $params;
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
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->params[$key];
    }
}
