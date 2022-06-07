<?php

declare(strict_types=1);

namespace Constellation\Tests\Routing;

use Constellation\Config\Application;
use Constellation\Http\Request;
use PHPUnit\Framework\TestCase;
use Constellation\Routing\Router;
use Constellation\Routing\Routes;
use Constellation\Service\Services;
use Constellation\Tests\Routing\Controllers\TestController;

/**
 * @class RouterTest
 */
class RouterTest extends TestCase
{
    public function setUp(): void
    {
        Application::$routing = [
            "enabled" => true,
            "controller_paths" => [
                __DIR__ . "/Controllers",
            ]
        ];
        (new Services)
            ->registerServices()
            ->bootServices();
    }

    public function testRouterInstance()
    {
        $router = Router::getInstance();
        $this->assertInstanceOf(Router::class, $router);
        $this->assertInstanceOf(Request::class, $router->getRequest());
    }

    public function testRouterRegisterServiceProvider()
    {
        $this->assertTrue(Application::$routing['enabled']);
        $this->assertSame(Application::$routing['controller_paths'], [__DIR__ . "/Controllers"]);
    }

    public function testRouterBootServiceProvider()
    {
        $this->assertTrue(count(Routes::getRoutes()) > 0);
    }

    public function testRouterResolution()
    {
        $router = (new Router(new Request("/", "GET")))->matchRoute();
        $class_name = $router->getRoute()?->getClassName();
        $endpoint = $router->getRoute()->getEndpoint();
        $this->assertNotNull($router->getRoute());
        $this->assertSame($class_name, TestController::class);
        $this->assertSame($endpoint, "index");
        $this->assertSame((new $class_name())->$endpoint(), "Hello, world!");
    }
}
