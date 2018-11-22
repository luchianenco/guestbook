<?php

namespace App\Container;

use App\Exception\LogicException;
use App\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 * @package App\Container
 */
class Container implements ContainerInterface
{
    /** @var array */
    private $resources;

    /**
     * Container constructor.
     * @param array $resources
     */
    public function __construct(array $resources = [])
    {
        $this->resources = $resources;
    }

    /**
     * @inheritdoc
     */
    public function has($id): bool
    {
        return isset($this->resources[$id]);
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        if (!isset($this->resources[$id])) {
            //$this->resources[$id] = $this->resolveClass($id);
            throw new NotFoundException(sprintf('The instance of %s has been not found', $id));
        }

        if ($this->resources[$id] instanceof \Closure) {
            return $this->resources[$id]();
        }

        return $this->resources[$id];
    }

    /**
     * @param string $id
     * @param $instance
     * @return $this
     */
    public function addInstance(string $id, $instance): Container
    {
        if (isset($this->resources[$id])) {
            throw new LogicException(sprintf('The resource id "%s" exists already!', $id));
        }

        $this->resources[$id] = $instance;

        return $this;
    }
}
