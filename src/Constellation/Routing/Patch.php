<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Patch
 */
#[Attribute]
class Patch extends Route
{
    public function __construct(
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = [],
        private string $method
    ) {
        parent::__construct($uri, $name, $middleware, "PATCH");
    }
}
