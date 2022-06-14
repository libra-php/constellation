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

    public function __construct(private string $template_filename, private array $data = [])
    {}

    public function boot()
    {
        $template_path = Application::$routing["template_path"];
        $this->loader = new Twig\Loader\FilesystemLoader($template_path);
        $default_options = [
            "cache" => Application::$routing["cache_path"]
        ];
        $this->twig = new Twig\Environment($this->loader, [...Application::$routing['twig_options'], ...$default_options]);
    }

    public function handle()
    {
        $this->twig->render($this->template_filename, $this->data);
    }
}
