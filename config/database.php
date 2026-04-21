<?php

$envPath = __DIR__ . '/../.env';
$env = [];

// file reading from .env and parsing key=value pairs
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        if (
            (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        $env[$key] = $value;
    }
}

return [
    'host' => $env['DB_HOST'] ?? getenv('DB_HOST'),
    'dbname' => $env['DB_NAME'] ?? getenv('DB_NAME'),
    'user' => $env['DB_USER'] ?? getenv('DB_USER'),
    'password' => $env['DB_PASSWORD'] ?? getenv('DB_PASSWORD') 
];