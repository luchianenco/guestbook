<?php

namespace App\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 * @package App\Exception
 */
class NotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}
