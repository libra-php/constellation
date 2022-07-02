<?php

namespace Constellation\Http;

/**
 * @class WebResponse
 */
class WebResponse implements IResponse
{
    private string $body;

    public function __construct(private ?string $data)
    {
    }

    public function prepare(): void
    {
        // Should something be done with the body?
        $this->body = $this->data;
    }

    public function execute(): never
    {
        echo $this->body;
        exit();
    }
}
