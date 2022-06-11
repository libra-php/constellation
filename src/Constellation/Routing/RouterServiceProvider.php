<?php

namespace Constellation\Routing;

use Constellation\Service\ServiceProvider;
use Constellation\Config\Application;
use Composer\Autoload\ClassMapGenerator;
use Constellation\Container\Container;
use ReflectionObject;

/**
 * @class RouterServiceProvider
 */
class RouterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfig(__DIR__ . "/Config.php", "routing");
    }

    public function boot()
    {
        if (Application::$routing["enabled"]) {
            $this->registerRoutes();
        }
    }

    public function classMap(string $path)
    {
        return ClassMapGenerator::createMap($path);
    }

    public function registerRoutes()
    {
        $controller_paths = Application::$routing["controller_paths"];
        foreach ($controller_paths as $path) {
            $controllers = $this->classMap($path);
            foreach ($controllers as $controller => $controller_path) {
                $object = new ReflectionObject(Container::getInstance()->get($controller));
                foreach ($object->getMethods() as $method) {
                    $attributes = $method->getAttributes();
                    foreach ($attributes as $attribute) {
                        $temp = explode("\\", $attribute->getName());
                        $request_method = strtoupper(end($temp));
                        $attribute = $attribute->getArguments();
                        $uri = $attribute[0] ?? "";
                        $name = $attribute[1] ?? null;
                        $middleware = $attribute[2] ?? [];
                        $hash = md5($uri);
                        if (!key_exists($hash, Routes::getRoutes())) {
                            Routes::addRoute(
                                $hash,
                                new Route(
                                    $uri,
                                    $name,
                                    $middleware,
                                    $request_method,
                                    "$controller",
                                    $method->getName()
                                )
                            );
                        }
                    }
                }
            }
        }
    }
}
