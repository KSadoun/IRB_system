<?php

$envPath = __DIR__ . '/../.env';
$env = [];

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
        $env[trim($key)] = trim($value);
    }
}

return [
    'mailer' => $env['MAIL_MAILER'] ?? 'smtp',
    'host' => $env['MAIL_HOST'] ?? '127.0.0.1',
    'port' => $env['MAIL_PORT'] ?? '25',
    'username' => $env['MAIL_USERNAME'] ?? null,
    'password' => $env['MAIL_PASSWORD'] ?? null,
    'encryption' => $env['MAIL_ENCRYPTION'] ?? null,
    'from_address' => $env['MAIL_FROM_ADDRESS'] ?? 'no-reply@irbsystem.local',
    'from_name' => $env['MAIL_FROM_NAME'] ?? 'IRB System',
];
