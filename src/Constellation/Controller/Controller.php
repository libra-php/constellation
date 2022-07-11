<?php

namespace Constellation\Controller;

use Constellation\Http\Request;
use Constellation\Routing\Router;
use Twig\Environment;
use Constellation\Validation\Validate;

/**
 * @class Controller
 */
class Controller
{
    public function __construct(
        protected Environment $twig,
        protected Request $request
    ) {
    }

    /**
     * @return string Body of twig template
     */
    public function render(string $template, ?array $data = []): string
    {
        $payload = [
            ...$data,
            "errors" => Validate::$errors,
            // Functions for twig templates
            "fn" => new class {
                public function buildRoute($name, ...$vars)
                {
                    return Router::buildRoute($name, ...$vars);
                }

                public function old($field)
                {
                    $request = Request::getInstance()->getData();
                    return $request[$field] ?? '';
                }
            },
        ];
        return $this->twig->render($template, $payload);
    }

    public function validateRequest(array $request_rules)
    {
        return Validate::request($this->request->getData(), $request_rules);
    }
}
