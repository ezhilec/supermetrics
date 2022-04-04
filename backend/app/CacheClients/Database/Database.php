<?php

namespace App\CacheClients\Database;

use App\Services\ConfigService;
use PDO;
use Exception;

class Database
{
    protected static ?PDO $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return PDO
     * @throws Exception
     */
    public static function getInstance(): PDO
    {
        $config = ConfigService::getInstance()->get('database');

        if (!self::$instance) {
            $dsn = "mysql:host=" . $config['host'] .
                ";dbname=" . $config['database'] .
                ";charset=" . $config['charset'];

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, $config['user'], $config['password'], $options);

            if (!$pdo) {
                throw new Exception("Can't connect to database");
            }

            self::$instance = $pdo;
        }
        return self::$instance;
    }
}