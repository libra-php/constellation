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
        private string $method,
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = []
    ) {
        parent::__construct("PUT", $uri, $name, $middleware);
    }
}
