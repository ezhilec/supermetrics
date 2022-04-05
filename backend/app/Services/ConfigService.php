<?php

namespace App\Services;

class ConfigService
{
    protected static ?ConfigService $instance = null;

    private array $configs = [];

    private function __construct()
    {
    }

    /**
     * @return ConfigService
     */
    public static function getInstance(): ConfigService
    {
        if (!self::$instance) {
            self::$instance = new ConfigService();
            if (!self::$instance->configs) {
                self::$instance->init();
            }
        }
        return self::$instance;
    }

    /**
     * @return void
     */
    private function init(): void
    {
        $rootDirectory = '/app';

        $this->configs = [
            'routes' => include $rootDirectory . '/config/routes.php',
            'supermetrics_api' => include $rootDirectory . '/config/supermetrics_api.php',
            'database' => include $rootDirectory . '/config/database.php',
            'posts' => include $rootDirectory . '/config/posts.php'
        ];
    }

    /**
     * @param string $key
     * @return array
     */
    public function get(string $key): array
    {
        return $this->configs[$key] ?? [];
    }

    private function __clone()
    {
    }
}