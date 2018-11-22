<?php

namespace App\Container;

use Psr\Container\ContainerInterface;

/**
 * Interface DefinitionResolverInterface
 * @package App\Container
 */
interface DefinitionResolverInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function resolve(string $id);

    /**
     * @param ContainerInterface $container
     * @return DefinitionResolverInterface
     */
    public function setContainer(ContainerInterface $container): DefinitionResolverInterface;
}
