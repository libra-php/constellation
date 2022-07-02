<?php

namespace Constellation\Http;

/**
 * @class ApiResponse
 */
class ApiResponse implements IResponse
{
    private array $payload = [];

    public function __construct(private ?array $data)
    {
    }

    public function prepare(): void
    {
        // Do something with the data?
        $this->payload["success"] =
            $data["success"] ?? http_response_code() === 200;
        $this->payload["message"] = $data["message"] ?? "";
        $this->payload["ts"] = time();
        $this->payload["date"] = date("Y-m-d H:i:s");
        $this->payload["data"] = $this->data;
    }

    public function execute(): never
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($this->payload, JSON_PRETTY_PRINT);
        exit();
    }
}
