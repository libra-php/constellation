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
}
