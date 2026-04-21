<?php

namespace App\Core;

use PDO;

class Model
{
    protected static PDO $db;

    public function __construct()
    {
        if (!self::$db) {
            $config = require __DIR__ . '/../../config/database.php';

            self::$db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['user'],
                $config['password']
            );

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
}