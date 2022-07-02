<?php

namespace Constellation\Controller;

use Twig\Environment;

/**
 * @class Controller
 */
class Controller
{
    public function __construct(protected Environment $twig)
    {
    }
}
