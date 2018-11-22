<?php

namespace App\Http\Message;

/**
 * Class Response
 * @package App\Http\Message
 */
class Response extends AbstractResponse
{
    private const HTTP_VERSION = '1.1';

    public const HTTP_OK = 200;
    public const HTTP_NOT_FOUND = 404;

    private const STATUS_TEXT = [
        200 => 'OK',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];

    /** @var int */
    private $statusCode;
    /** @var string */
    private $statusText;
    /** @var string */
    private $content;

    /**
     * Response constructor.
     * @param $statusCode
     * @param string $content
     */
    public function __construct($statusCode, string $content = '')
    {
        $this->statusCode = $statusCode;
        $this->statusText = self::STATUS_TEXT[$statusCode];
        $this->content = $content;
        $this->headers = [];
    }

    /**
     * Output Response Content
     */
    public function send(): void
    {
        $this->setHeaders();
        $this->sendResponseHeader();

        echo $this->content;
    }

    /**
     * Send HTTP Headers
     */
    private function sendResponseHeader(): void
    {
        // Sent Content
        header(
            sprintf('HTTP/%s %s %s', self::HTTP_VERSION, $this->statusCode, $this->statusText),
            true,
            $this->statusCode
        );
    }
}
