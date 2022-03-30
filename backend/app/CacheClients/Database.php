<?php

namespace App\CacheClients;

use \PDO;

class Database
{

    //todo get from config
    private static $config = [
        'host' => 'supermetrics-database',
        'database' => 'supermetrics',
        'user' => 'root',
        'password' => 'root',
        'charset' => 'utf8'
    ];

    protected static ?PDO $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            $dsn = "mysql:host=" . self::$config['host'] .
                ";dbname=" . self::$config['database'] .
                ";charset=" . self::$config['charset'];

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, self::$config['user'], self::$config['password'], $options);

            if (!$pdo) {
                throw new \Exception("Can't connect to database");
            }

            self::$instance = $pdo;
        }
        return self::$instance;
    }
}