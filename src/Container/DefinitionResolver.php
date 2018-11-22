<?php

namespace App\Container;

use App\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Class DefinitionResolver
 * @package App\Container
 */
class DefinitionResolver implements DefinitionResolverInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param string $id
     * @return object
     * @throws \ReflectionException
     */
    public function resolve(string $id)
    {
        $reflector = new \ReflectionClass($id);

        if (!$reflector->isInstantiable()) {
            throw new NotFoundException(sprintf('Class %s not found', $id));
        }

        /** @var \ReflectionMethod|null */
        $constructor = $reflector->getConstructor();

        if (null === $constructor) {
            return new $id();
        }

        $dependencies = array_map(
            function (\ReflectionParameter $dependency) use ($id) {
                if (null === $dependency->getClass()) {
                    throw new NotFoundException(sprintf('Class %s not found', $id));
                }

                return $this->get($dependency->getClass()->getName());
            },
            $constructor->getParameters()
        );

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @param ContainerInterface $container
     * @return DefinitionResolverInterface
     */
    public function setContainer(ContainerInterface $container): DefinitionResolverInterface
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param string $id
     * @return object
     * @throws \ReflectionException
     */
    private function get(string $id)
    {
        if (!$this->container instanceof ContainerInterface || !$this->container->has($id)) {
            return $this->resolve($id);
        }

        return $this->container->get($id);
    }
}
