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
            Router::class => \DI\autowire()
            ->constructorParameter("config", $this->config)
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
}
