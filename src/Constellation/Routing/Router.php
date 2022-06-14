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
    private array $params;

    public function __construct(private Request $request)
    {
    }

    public static function findRoute(string $name)
    {
        $routes = array_filter(
            Routes::getRoutes(),
            fn($route) => $route->getName() === $name
        );
        if (!empty($routes) && count($routes) === 1) {
            return reset($routes);
        }
        return null;
    }

    public static function buildUri(string $name, ...$vars)
    {
        $route = Router::findRoute($name);
        if ($route) {
            $regex = "#({[\w\?]+})#";
            $uri = $route->getUri();
            preg_match_all($regex, $uri, $matches);
            if ($matches) {
                array_walk(
                    $matches[0],
                    fn(&$item) => ($item =
                        "#" . str_replace("?", "\?", $item) . "#")
                );
                return preg_replace($matches[0], $vars, $uri);
            }
        }
        return null;
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

    public function getParams()
    {
        return $this->params;
    }

    public function matchRoute()
    {
        $route_array = array_filter(Routes::getRoutes(), function ($route) {
            $uri = $route->getUri();
            // Replace placeholders
            $uri = preg_replace("#{[\w]+}#", "([\w\-\_]+)", $uri);
            // Handle optional placeholders
            $uri = preg_replace("#{[\w\?]+}#", "([\w\-\_]+)?", $uri);
            // Escape characters
            $clean_uri = str_replace("/", "\/?", $uri);

            // Prepare URI for regex test
            $re = "#^{$clean_uri}$#i";
            $attribute_uri = $this->request->getUri();
            $result = preg_match($re, $attribute_uri, $matches);

            if ($matches) {
                unset($matches[0]);
                $matches = array_values($matches);
                $this->params = $matches;
            }

            return $result;
        });
        if ($route_array && count($route_array) === 1) {
            $this->route = reset($route_array);
        }
        return $this;
    }
}
