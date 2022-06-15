<?php

namespace Constellation\Http;

use Constellation\Container\Container;
use Exception;

/**
 * @class Request
 */
class Request
{
    public static $instance;
    private $uri;
    private $method;

    public function __construct(string $uri = "/", string $method = "GET", $data = [])
    {
        $this->setUri($uri);
        $this->setMethod($method);
        $this->setData($data);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Request::class);
        }

        return static::$instance;
    }

    private function setUri(string $uri)
    {
        $uri = $this->filterUri($uri);
        $this->uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    private function setMethod(string $method)
    {
        $this->validateRequestMethod($method);
        $this->method = $method;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    private function setData(array $data)
    {
        $this->data = $this->validateData($data);
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    protected function filterUri(string $uri)
    {
        $uri = strtok($uri, "?");
        return htmlspecialchars(strip_tags($uri));
    }

    protected function validateRequestMethod(string $method)
    {
        if (
            !in_array($method, [
                "GET",
                "POST",
                "PUT",
                "PATCH",
                "DELETE",
                "HEAD",
            ])
        ) {
            throw new Exception("Invalid request method");
        }
    }

    protected function validateData(array $data)
    {
        return $this->data = $data;
    }
}
