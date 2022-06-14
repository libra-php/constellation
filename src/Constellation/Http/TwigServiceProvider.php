<?php

namespace Constellation\Http;

use Constellation\Service\ServiceProvider;

/**
 * @class TwigServiceProvider
 */
class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfig(__DIR__ . "/Config.php", "templating");
    }
}
