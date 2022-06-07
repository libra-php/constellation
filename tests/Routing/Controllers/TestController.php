<?php

namespace Constellation\Tests\Routing\Controllers;

use Constellation\Controller\Controller;
use Constellation\Routing\Get;

/**
 * @class TestController
 */
class TestController extends Controller
{
    #[Get('/', 'test.index')]
    public function index()
    {
        return "Hello, world!";
    }

    #[Get('/home', 'test.home')]
    public function home()
    {
        return "Honey! I'm home!";
    }
}
