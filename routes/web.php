<?php

use App\Core\App;

App::$router->get('/', ['HomeController', 'index']);
App::$router->get('/login', ['AuthController', 'login']);
App::$router->post('/login', ['AuthController', 'authenticate']);
App::$router->get('/logout', ['AuthController', 'logout']);