<?php

namespace Constellation\Config;

use Constellation\Routing\RouterServiceProvider;

/**
 * @class Application
 */
class Application
{
    public static $routing = [];

    public static $services = [
        "routing" => RouterServiceProvider::class,
    ];
}
