<?php

namespace Constellation\Controller;

use Constellation\Routing\Router;
use Twig\Environment;

/**
 * @class Controller
 */
class Controller
{
    public function __construct(protected Environment $twig)
    {
    }

    /**
     * @return string Body of twig template
     */
    public function render(string $template, ?array $data = []): string
    {
        $payload = [
            ...$data,
            // Functions for twig templates
            "fn" => new class {
                public function buildRoute($name, ...$vars)
                {
                    return Router::buildRoute($name, ...$vars);
                }
            },
        ];
        return $this->twig->render($template, $payload);
    }
}
