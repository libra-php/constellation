<?php

namespace Constellation\Tests\Routing\Controllers;

use Constellation\Routing\Get;

class BasicController
{
    #[Get('/basic', 'basic.index')] 
    public function index()
    {
        return "Hello, world";
    } 
}
