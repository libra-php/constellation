<?php

namespace Constellation\Http;

use Constellation\Config\Application;
use Twig;

/**
 * @class TwigResponse
 */
class TwigResponse implements ResponseInterface
{
    private $loader;
    private $twig;

    public function __construct(private string $template, private array $data = [])
    {}

    public function boot()
    {
        $template_path = Application::$templating["template_path"];
        $this->loader = new Twig\Loader\FilesystemLoader($template_path);
        $options = [
            "cache" => Application::$templating["cache_path"],
            "auto_reload" => true,
        ];
        $this->twig = new Twig\Environment($this->loader, $options);
    }

    public function handle()
    {
        return $this->twig->render($this->template, $this->data);
    }
}
