<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Put
 */
#[Attribute]
class Put extends Route
{
    public function __construct(
        private string $uri,
        private string $name,
        private string|array $middleware,
        private string $method
    ) {
        parent::__construct($uri, $name, $middleware, "PUT");
    }
}