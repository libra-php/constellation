<?php

namespace Constellation\Http;

use Constellation\Validation\Validate;

class ApiResponse implements IResponse
{
    private array $payload = [];

    public function __construct(private ?array $data)
    {
    }
    public function prepare()
    {
        // Do something with the data?
        $this->payload["success"] =
            $data["success"] ?? http_response_code() === 200;
        $this->payload["message"] = $data["message"] ?? "";
        $this->payload["ts"] = time();
        $this->payload["date"] = date("Y-m-d H:i:s");
    }
    public function execute()
    {
        echo json_encode($this->payload);
    }
}
