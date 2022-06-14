<?php

namespace Constellation\Controller;

use Constellation\Http\Request;
use Constellation\Http\Response;
use Constellation\Http\JSONResponse;
use Constellation\Http\TwigResponse;
use Constellation\Model\User;

/**
 * @class Controller
 */
class Controller
{
    public string $template;
    public array $data = [];
    private $response = null;

    public function __construct(
        private Request $request,
        private User $user
    ) {
    }

    public function buildResponse(array $route_middleware)
    {
        switch (true) {
            case in_array('api', $route_middleware):
                $this->response = new Response(new JSONResponse());
                break;
            default:
                $this->response = new Response(new TwigResponse($this->template, $this->data));
        }
        return $this;
    }

    public function getContent()
    {
        return trim($this->response->content());
    }
}
