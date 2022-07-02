<?php

namespace Constellation\Http;

class WebResponse implements IResponse
{
    private string $body;
    public function __construct(private ?string $data)
    {
    }
    public function prepare()
    {
        // Should something be done with the body?
        $this->body = $this->data;
    }
    public function execute()
    {
        echo $this->body;
    }
}
