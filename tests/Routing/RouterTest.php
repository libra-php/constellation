<?php

declare(strict_types=1);

namespace Constellation\Tests\Routing;

use Constellation\Config\Application;
use Constellation\Container\Container;
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
            "controller_paths" => [__DIR__ . "/Controllers"],
        ];
        (new Services())->registerServices()->bootServices();
    }

    public function testRouterInstance()
    {
        $router = Router::getInstance();
        $this->assertInstanceOf(Router::class, $router);
        $this->assertInstanceOf(Request::class, $router->getRequest());
    }

    public function testRouterRegisterServiceProvider()
    {
        $this->assertTrue(Application::$routing["enabled"]);
        $this->assertSame(
            [__DIR__ . "/Controllers"],
            Application::$routing["controller_paths"]
        );
    }

    public function testRouterBootServiceProvider()
    {
        $this->assertTrue(count(Routes::getRoutes()) > 0);
    }

    public function testRouterBasicRouteResolution()
    {
        $router = (new Router(new Request("/home")))->matchRoute();
        $class_name = $router->getRoute()?->getClassName();
        $endpoint = $router->getRoute()?->getEndpoint();
        $this->assertNotNull($router->getRoute());
        $this->assertSame(TestController::class, $class_name);
        $this->assertSame("home", $endpoint);
        $this->assertSame("Honey! I'm home!", (Container::getInstance()->get($class_name))->$endpoint());
    }

    public function testRouterRouteResolutionWithGetParam()
    {
        $router = (new Router(new Request("/?test=derp")))->matchRoute();
        $class_name = $router->getRoute()?->getClassName();
        $endpoint = $router->getRoute()?->getEndpoint();
        $this->assertNotNull($router->getRoute());
        $this->assertSame(TestController::class, $class_name);
        $this->assertSame("index", $endpoint);
        $this->assertSame("Hello, world!", (Container::getInstance()->get($class_name))->$endpoint());
    }

    public function testRouterBasicUriSingleParam()
    {
        $router = (new Router(new Request("/william/age/35")))->matchRoute();
        $this->assertSame([0 => "35"], $router->getParams());
    }

    public function testRouterBasicUriMultiParam()
    {
        $router = (new Router(
            new Request(
                "/user/06c16921-9b95-41f7-8407-c1a113a68be3/profile/100339"
            )
        ))->matchRoute();
        $this->assertSame(
            [0 => "06c16921-9b95-41f7-8407-c1a113a68be3", 1 => "100339"],
            $router->getParams()
        );
    }

    public function testRouterBasicUriOptionalParam()
    {
        $router = (new Router(new Request("/photo/200302/edit")))->matchRoute();
        $this->assertSame([0 => "200302", 1 => "edit"], $router->getParams());

        $router = (new Router(new Request("/photo/200302")))->matchRoute();
        $this->assertSame([0 => "200302"], $router->getParams());
    }

    public function testRouterFindRoute()
    {
        $route = Router::findRoute("test.age");
        $this->assertNotNull($route);
        $this->assertSame("test.age", $route?->getName());
    }

    public function testRouterBuildUri()
    {
        $uri = Router::buildUri(
            "test.profile",
            "06c16921-9b95-41f7-8407-c1a113a68be3",
            "100339"
        );
        $this->assertSame(
            "/user/06c16921-9b95-41f7-8407-c1a113a68be3/profile/100339",
            $uri
        );
    }
}
