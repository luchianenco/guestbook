<?php

namespace App\Http\Message;

/**
 * Interface RequestInterface
 * Note: PSR7 Message Interface Not Used to reduce the implementation time
 * @package App\Http\Message
 */
interface RequestInterface
{
    /**
     * Get Request Method
     * @return string
     */
    public function getRequestMethod(): string;

    /**
     * @return string
     */
    public function getRoute(): string;

    /**
     * Get Request Parameters
     * @param string $key
     * @return mixed
     */
    public function get(string $key);
}
