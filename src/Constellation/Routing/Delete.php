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
        private string $method,
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = []
    ) {
        parent::__construct("DELETE", $uri, $name, $middleware);
    }
}
