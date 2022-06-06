<?php

namespace Constellation\Service;

use Constellation\Config\Application;

class Services
{
    public function registerServices()
    {
        foreach (Application::$services as $key => $service) {
            $target = new $service();
            $target->register();
        }
        return $this;
    }

    public function bootServices()
    {
        foreach (Application::$services as $key => $service) {
            $target = new $service();
            $target->boot();
        }
        return $this;
    }
}
