<?php

namespace App\Container;

use Psr\Container\ContainerInterface;

/**
 * Class ContainerBuilder
 * @package App\Container
 */
class ContainerBuilder
{
    /** @var DefinitionResolverInterface */
    private $resolver;

    /**
     * ContainerBuilder constructor.
     * @param DefinitionResolverInterface $resolver
     */
    public function __construct(DefinitionResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Build Container based on Provided Configuration
     * @param ConfigurationInterface $configuration
     * @return ContainerInterface
     */
    public function build(ConfigurationInterface $configuration): ContainerInterface
    {
        $container = new Container();
        $instances = $configuration->getInstances();
        foreach ($instances as $id => $instance) {
            $container->addInstance($id, $instance);
        }

        $definitions = $configuration->getDefinitions();
        $this->resolver->setContainer($container);

        foreach ($definitions as $id => $definition) {
            if (false !== filter_var($id, FILTER_VALIDATE_INT)) {
                $id = $definition;
            }

            // Use lazy loading for the container
            // this will create a new object on every container get
            // TODO create a possibility to have shareable instances
            // TODO without creating a new instance on each get request
            $closure = function () use ($definition) {
                return $this->resolver->resolve($definition);
            };
            $container->addInstance($id, $closure);
        }

        return $container;
    }
}
