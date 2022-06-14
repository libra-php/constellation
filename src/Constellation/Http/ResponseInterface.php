<?php

namespace Constellation\Http;

/**
 * @interface ResponseInterface
 */
interface ResponseInterface
{
    public function boot();
    public function handle();
}
