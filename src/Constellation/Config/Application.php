<?php

namespace Constellation\Config;

use Constellation\Routing\RouterServiceProvider;
use Constellation\Http\TwigServiceProvider;

/**
 * @class Application
 */
class Application
{
    public static $routing = [];
    public static $templating = [];
    public static $services = [
        "routing" => RouterServiceProvider::class,
        "templating" => TwigServiceProvider::class,
    ];
}
