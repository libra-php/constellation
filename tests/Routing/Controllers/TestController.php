<?php

namespace Constellation\Tests\Routing\Controllers;

use Constellation\Controller\Controller;
use Constellation\Routing\Get;

class TestController extends Controller
{
    #[Get('/', 'test.index', [])]
    public function index()
    {
    }
}
