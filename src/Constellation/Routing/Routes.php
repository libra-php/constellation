<?php

namespace Constellation\Routing;

class Routes
{
    private static $routes = [];

    public static function addRoute(string $hash, Route $route)
    {
        self::$routes[$hash] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }
}
