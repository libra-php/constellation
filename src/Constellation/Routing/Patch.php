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
        private string $method,
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = []
    ) {
        parent::__construct("PATCH", $uri, $name, $middleware);
    }
}
