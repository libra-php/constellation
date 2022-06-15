<?php

namespace Constellation\Routing;

use Constellation\Container\Container;

/**
 * @class Routes
 */
class Routes
{
    protected static $instance;
    private $routes = [];

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Routes::class);
        }

        return static::$instance;
    }

    public function addRoute(string $hash, Route $route)
    {
        $this->routes[$hash] = $route;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
