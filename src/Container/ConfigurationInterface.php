<?php

namespace App\Container;

/**
 * Interface ConfigurationInterface
 * @package App\Container
 */
interface ConfigurationInterface
{
    /**
     * @return array
     */
    public function getInstances(): array;

    /**
     * @return array
     */
    public function getDefinitions(): array;
}
