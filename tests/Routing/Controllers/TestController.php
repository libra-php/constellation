<?php

namespace Constellation\Tests\Routing\Controllers;

use Constellation\Controller\Controller;
use Constellation\Routing\Get;

/**
 * @class TestController
 */
class TestController extends Controller
{
    #[Get("/", "test.index")]
    public function index()
    {
        return "Hello, world!";
    }

    #[Get("/home", "test.home")]
    public function home()
    {
        return "Honey! I'm home!";
    }

    #[Get("/template", "test.template")]
    public function template()
    {
        return ["test/index.html", ["test" => "It works!"]];
    }

    #[Get("/william/age/{age}", "test.age")]
    public function age($age) {
        return $age;
    }

    #[Get("/user/{uuid}/profile/{id}", "test.profile")]
    public function profile($uuid, $id) {
        return [$uuid, $id];
    }

    #[Get("/photo/{id}/{command?}", "test.photo")]
    public function photo($id, $command = null) {
        return [$id, $command];
    }
}
