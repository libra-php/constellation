<?php

declare(strict_types=1);

namespace Constellation\Tests\Routing;

use Constellation\Container\Container;
use PHPUnit\Framework\TestCase;
use Constellation\Routing\Router;

/**
 * @class RouterTest
 */
class RouterTest extends TestCase
{
    public function setUp(): void
    {
        $container = Container::getInstance();
        $container->setDefinitions([
            Router::class => \DI\autowire()->constructorParameter("config", [
                "controller_path" => __DIR__ . "/Controllers",
            ]),
        ]);
        $container->build();
        $this->router = Router::getInstance();
    }

    public function testRouterInstance()
    {
        $this->assertInstanceOf(Router::class, $this->router);
    }
}
