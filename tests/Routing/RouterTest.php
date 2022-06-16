<?php

declare(strict_types=1);

namespace Constellation\Tests\Routing;

use Constellation\Container\Container;
use Constellation\Http\Request;
use PHPUnit\Framework\TestCase;
use Constellation\Routing\Router;

/**
 * @class RouterTest
 */
class RouterTest extends TestCase
{
    public function setUp(): void
    {
        $this->config = [
            "controller_path" => __DIR__ . "/Controllers",
        ];
    }

    public function testRouterInstance()
    {
        $container = Container::getInstance();
        $container->setDefinitions([
            Router::class => \DI\autowire()->constructorParameter(
                "config",
                $this->config
            ),
        ]);
        $container->build();
        $this->router = Router::getInstance();
        $this->assertInstanceOf(Router::class, $this->router);
    }

    public function testRouterMatchRoute()
    {
        $this->router = new Router($this->config, new Request("/basic"));
        $this->router->registerRoutes()->matchRoute();
        $this->assertSame($this->router->getRoute()->getUri(), "/basic");
        $this->assertSame($this->router->getRoute()->getMethod(), "GET");
    }

    public function testRouterGetRouteByName()
    {
        $route = Router::findRoute("basic.name-age");
        $this->assertSame("/basic/{name}/{age}", $route->getUri());
        $this->assertSame("basic.name-age", $route->getName());
        $this->assertSame(["test"], $route->getMiddleware());
    }

    public function testRouterRouteParams()
    {
        $this->router = new Router(
            $this->config,
            new Request("/basic/william/35")
        );
        $this->router->registerRoutes()->matchRoute();
        $this->assertSame(
            $this->router->getRoute()->getUri(),
            "/basic/{name}/{age}"
        );
        $this->assertSame($this->router->getRoute()->getParams(), [
            "william",
            "35",
        ]);
    }

    public function testRouterBuildRoute()
    {
        $uri = Router::buildRoute("basic.name-age", "william", 21);
        $this->assertSame("/basic/william/21", $uri);
    }

    public function testRouterRouteEndpoint()
    {
        $this->router = new Router(
            $this->config,
            new Request("/basic/William/18")
        );
        $this->router->registerRoutes()->matchRoute();
        $route = $this->router->getRoute();
        $class_name = $route->getClassName();
        $endpoint = $route->getEndpoint();
        $params = $route->getParams();
        $class = new $class_name();
        $response = $class->$endpoint(...$params);
        $this->assertSame("Hello, William. You're 18.", $response);
    }
}
