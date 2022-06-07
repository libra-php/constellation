<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Delete
 */
#[Attribute]
class Delete extends Route
{
    public function __construct(
        private string $uri,
        private string $name,
        private string|array $middleware,
        private string $method
    ) {
        parent::__construct($uri, $name, $middleware, "DELETE");
    }
}
