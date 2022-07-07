<?php

namespace Constellation\Routing;

use Composer\Autoload\ClassMapGenerator;
use Constellation\Container\Container;
use Constellation\Http\Request;
use Constellation\Validation\Validate;
use ReflectionObject;

/**
 * @class Router
 */
class Router
{
    protected static $instance;
    private ?Route $route = null;
    private $request_method;

    public function __construct(private array $config, private Request $request)
    {
        Validate::keys($this->config, ["controller_path"]);
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

    public function pageNotFound()
    {
        $protocol = $_SERVER["SERVER_PROTOCOL"] ?? "HTTP/1.0";
        header($protocol . " 404 Not Found", true, 404);
        print "Page not found";
        exit();
    }

    public function classMap(string $path)
    {
        return ClassMapGenerator::createMap($path);
    }

    public function registerRoutes()
    {
        $controllers = $this->classMap($this->config["controller_path"]);
        foreach ($controllers as $controller => $controller_path) {
            $object = new ReflectionObject(
                Container::getInstance()->get($controller)
            );
            foreach ($object->getMethods() as $method) {
                $attributes = $method->getAttributes();
                foreach ($attributes as $attribute) {
                    $routes = Routes::getInstance();
                    $temp = explode("\\", $attribute->getName());
                    $request_method = strtoupper(end($temp));
                    $attribute = $attribute->getArguments();
                    $uri = $attribute[0] ?? "";
                    $name = $attribute[1] ?? null;
                    $middleware = $attribute[2] ?? [];
                    $hash = md5($request_method . $uri);
                    if (!key_exists($hash, $routes->getRoutes())) {
                        $routes->addRoute(
                            $hash,
                            new Route(
                                $request_method,
                                $uri,
                                $name,
                                $middleware,
                                "$controller",
                                $method->getName()
                            )
                        );
                    }
                }
            }
        }
        return $this;
    }

    public static function findRoute(string $name)
    {
        $routes = array_filter(
            Routes::getInstance()->getRoutes(),
            fn($route) => $route->getName() === $name
        );
        if (!empty($routes) && count($routes) === 1) {
            return reset($routes);
        }
        return null;
    }

    public static function buildRoute(string $name, ...$vars)
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

    public function matchRoute()
    {
        $params = [];
        $route_array = array_filter(
            Routes::getInstance()->getRoutes(),
            function ($route) use (&$params) {
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

                // If there are matches bind to params
                if ($matches) {
                    unset($matches[0]);
                    $matches = array_values($matches);
                    $params = $matches;
                }

                return $result &&
                    $route->getMethod() === $this->request->getMethod();
            }
        );
        // Set the route if we matched one successfully
        if ($route_array && count($route_array) === 1) {
            $this->route = reset($route_array);
            if (!empty($params)) {
                $this->route->setParams($params);
            }
        }
        return $this;
    }
}
