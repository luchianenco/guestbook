<?php

namespace App\Container;

use Psr\Container\ContainerInterface;

/**
 * Interface ContainerBuilderInterface
 * @package App\Container
 */
interface ContainerBuilderInterface
{
    /**
     * @param ConfigurationInterface $configuration
     * @return ContainerInterface
     */
    public function build(ConfigurationInterface $configuration): ContainerInterface;
}
