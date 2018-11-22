<?php

namespace App\Http\Message;

/**
 * Interface ResponseInterface
 * @package App\Http\Message
 */
interface ResponseInterface
{
    /**
     * Outputs Response Content
     */
    public function send(): void;

    /**
     * @param string $name
     * @param string $value
     * @return ResponseInterface
     */
    public function addHeader(string $name, string $value): ResponseInterface;
}
