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
                 // The params will be stored in index 1, 2, etc
                // URI is index 0, so we can remove that and re-index
                unset($matches[0]);
                $matches = array_values($matches);
                $this->params = $matches; 
            }

            return $result;
        });
        if ($route_array && count($route_array) == 1) {
            $this->route = array_pop($route_array);
        }
        return $this;
    }
}
