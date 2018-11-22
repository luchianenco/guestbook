<?php

namespace App\Http\Message\Factory;

use App\Http\Message\Request;
use App\Http\Message\RequestInterface;

/**
 * Class RequestFactory
 * @package App\Http\Message\Factory
 */
class RequestFactory
{
    /**
     * @return RequestInterface
     */
    public static function create() :RequestInterface
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $params = self::getParams($method);

        return new Request($method, $route, $params);
    }

    /**
     * @param string $method
     * @return array
     */
    private static function getParams(string $method): array
    {
        $content = [];
        $inputType = $method === Request::POST ? INPUT_POST : INPUT_GET;
        $params = $method === Request::POST ? $_POST : $_GET;
        foreach ($params as $key => $value) {
            $content[$key] = filter_input($inputType, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $content;
    }
}
