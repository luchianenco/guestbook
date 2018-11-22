<?php

namespace App\Http\Message;

/**
 * Class AbstractResponse
 * @package App\Http\Message
 */
abstract class AbstractResponse implements ResponseInterface
{
    /** @var array */
    protected $headers;

    /**
     * Send the HTTP Response
     */
    abstract public function send(): void;

    /**
     * @param string $name
     * @param string $value
     * @return ResponseInterface
     */
    public function addHeader(string $name, string $value): ResponseInterface
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Set Headers
     */
    protected function setHeaders(): void
    {
        foreach ($this->headers as $headerName => $value) {
            header($headerName . ': ' . $value);
        }
    }
}
