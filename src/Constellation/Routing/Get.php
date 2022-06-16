<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Get
 */
#[Attribute]
class Get extends Route
{
    public function __construct(
        private string $method,
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = [],
    ) {
        parent::__construct("GET", $uri, $name, $middleware);
    }
}
