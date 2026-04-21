<?php

// require_once __DIR__ . '/../vendor/autoload.php';

// autoload classes from the 'app' directory
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use App\Core\App;

$app = new App();

require_once __DIR__ . '/../routes/web.php';

$app->run();