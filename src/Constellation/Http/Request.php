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

    public function __construct(
        private ?string $uri = null,
        private ?string $method = null
    ) {
        if ($uri) {
            $this->setUri($uri);
        } else {
            $this->setUri($_SERVER["REQUEST_URI"] ?? "");
        }
        if ($method) {
            $this->setMethod($method);
        } else {
            $this->setMethod($_SERVER["REQUEST_METHOD"] ?? "GET");
        }
        $this->setData($_REQUEST ?? []);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Request::class);
        }

        return static::$instance;
    }

    public function setUri(string $uri)
    {
        $uri = $this->filterUri($uri);
        $this->uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setMethod(string $method)
    {
        $this->validateRequestMethod($method);
        $this->method = $method;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    private function filterUri(string $uri)
    {
        // Remove params from uri
        $uri = strtok($uri, "?");
        return htmlspecialchars(strip_tags($uri));
    }

    private function validateRequestMethod(string $method)
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
}
