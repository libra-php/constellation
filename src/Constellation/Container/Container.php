<?php

namespace Constellation\Container;

use DI\ContainerBuilder;

/**
 * @class Container
 */
class Container
{
    protected static $instance;
    private array|string $definitions = [];
    private $container;
    private $builder;

    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function build(): Container
    {
        $this->builder = new ContainerBuilder();
        if (!empty($this->definitions)) {
            $this->builder->addDefinitions($this->definitions);
        }
        $this->container = $this->builder->build();
        return $this;
    }

    public function get($target)
    {
        return $this->container?->get($target);
    }

    public function setDefinitions(array|string $defintions): Container
    {
        if (!empty($defintions) || is_string($defintions)) {
            $this->definitions = $defintions;
        }
        return $this;
    }
}
