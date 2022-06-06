<?php

namespace Constellation\Routing;

use Constellation\Http\Request;
use Constellation\Container\Container;

/**
 * @class Router
 */
class Router
{
    protected static $instance;

    public function __construct(
        private Request $request
    ){}

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Router::class);
        }

        return static::$instance;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
