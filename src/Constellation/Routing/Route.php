<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Route
 */
#[Attribute]
class Route
{
    public function __construct(
        private string $uri,
        private string $name,
        private string|array $middleware,
        private string $method
    ) {
    }

    public function getUri()
    {
        return $this->uri;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getMiddleware()
    {
        return $this->middleware;
    }
    public function getMethod()
    {
        return $this->method;
    }
}
