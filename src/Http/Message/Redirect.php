<?php

namespace App\Http\Message;

/**
 * Class Redirect
 * @package App\Http\Message
 */
class Redirect extends AbstractResponse
{
    /** @var string */
    private $location;

    /**
     * Redirect constructor.
     * @param string $location
     */
    public function __construct(string $location)
    {
        $this->headers = [];
        $this->location = $location;
    }

    /**
     * Outputs Response Content
     */
    public function send(): void
    {
        $this->setHeaders();
        header('Location: ' . $this->location);
    }
}
