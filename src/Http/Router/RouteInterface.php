<?php

namespace App\Http\Router;

/**
 * Class Route
 * @package App\Http\Router
 */
interface RouteInterface
{
    /**
     * @return string
     */
    public function getRoute(): string;

    /**
     * @return string
     */
    public function getRequestMethod(): string;

    /**
     * @return string
     */
    public function getController(): string;

    /**
     * @return string
     */
    public function getControllerMethod(): string;
}
