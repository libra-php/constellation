<?php

namespace Constellation\Http;

/**
 * @class Response
 */
class Response
{
    public function __construct(private ResponseInterface $interface)
    {
        $this->interface->boot();
    }

    public function content()
    {
        return $this->interface->handle();
    }
}
