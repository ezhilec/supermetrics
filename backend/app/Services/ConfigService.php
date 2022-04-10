<?php

namespace App\Services;

use Exception;

class ConfigService
{
    protected static ?ConfigService $instance = null;

    private array $configs = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return ConfigService
     * @throws Exception
     */
    public static function instance(): ConfigService
    {
        try {
            EnvService::init();
        }  catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

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
        $rootDirectory = "/app";

        $this->configs = [
            "routes" => include "$rootDirectory/config/routes.php",
            "supermetrics_api" => include "$rootDirectory/config/supermetrics_api.php",
            "database" => include "$rootDirectory/config/database.php",
            "posts" => include "$rootDirectory/config/posts.php",
        ];
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function get(string $path): mixed
    {
        [$configName, $key] = explode(".", $path . ".");

        if (!$key) {
            return $this->configs[$configName];
        }

        return $this->configs[$configName][$key];
    }
}