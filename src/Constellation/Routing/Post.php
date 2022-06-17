<?php

namespace Constellation\Routing;

use Attribute;

/**
 * @class Post
 */
#[Attribute]
class Post extends Route
{
    public function __construct(
        private string $method,
        private string $uri,
        private ?string $name = null,
        private string|array $middleware = []
    ) {
        parent::__construct("POST", $uri, $name, $middleware);
    }
}
