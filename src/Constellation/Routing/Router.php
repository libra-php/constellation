<?php

namespace Constellation\Routing;

use Constellation\Http\Request;
use Constellation\Container\Container;

/**
 * @class Router
 */
class Router
{
    protected static $instance;
    private ?Route $route = null;

    public function __construct(private Request $request)
    {
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Router::class);
        }

        return static::$instance;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function matchRoute()
    {
        $route_array = array_filter(Routes::getRoutes(), function ($route) {
            return $route->getUri() === $this->request->getUri() &&
                $route->getMethod() === $this->request->getMethod();
        });
        if ($route_array && count($route_array) == 1) {
            $this->route = array_pop($route_array);
        }
        return $this;
    }
}
