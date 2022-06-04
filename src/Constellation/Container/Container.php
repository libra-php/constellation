<?php

namespace Constellation\Container;

use DI\ContainerBuilder;

class Container
{
    protected static $instance;
    private $definitions = [];
    private $container;
    private $builder;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function build()
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
        return $this->container->get($target);
    }

    public function setDefinitions(array $defintions)
    {
        if (!empty($defintions)) {
            $this->definitions = $defintions;
        }
    }
}
