<?php

namespace App\Core;

class App
{
    public static Router $router;

    public function __construct()
    {
        self::$router = new Router();
    }

    public function run()
    {
        self::$router->resolve();
    }
}