<?php

namespace Constellation\Service;

use Constellation\Config\Application;

/**
 * @class ServiceProvider
 */
class ServiceProvider
{
    public function register()
    {
    }
    public function boot()
    {
    }
    public function mergeConfig(string $default, string $target)
    {
        if (file_exists($default)) {
            $default_config = require_once $default;
            if (is_array($default_config) && !empty($default_config)) {
                Application::$$target = array_merge($default_config, Application::$$target);
            }
        }
    }
}
