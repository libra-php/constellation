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

    #[Get('/basic/{name}/{age}', 'basic.name-age', ['test'])] 
    public function index1($name, $age)
    {
        return "Hello {$name}, you're {$age} years old.";
    } 
}
