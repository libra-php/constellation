<?php

namespace Constellation\Service;

use Constellation\Config\Application;

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
        $default_config = require_once $default;
        if (is_array($default_config) && !empty($default_config)) {
            foreach ($default_config as $key => $value) {
                Application::$$target[$key] =
                    Application::$$target[$key] ?? $value;
            }
        }
    }
}
