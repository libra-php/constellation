<?php

namespace Constellation\Tests\Routing\Controllers;

use Constellation\Routing\Get;
use Constellation\Controller\Controller;

class BasicController extends Controller
{
    #[Get("/basic", "basic.index")]
    public function index()
    {
        return "Hello, world";
    }

    #[Get("/basic/{name}/{?age}", "basic.name-age", ["test"])]
    public function index1($name, $age) {
        return "Hello, {$name}. You're {$age}.";
    }
}
