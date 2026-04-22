<?php

if (($_SERVER['APP_DEBUG'] ?? '0') === '1') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

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