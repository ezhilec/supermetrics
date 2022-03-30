<?php

namespace App\Services;

class ConfigService
{
    private array $configs = [];

    public function __construct()
    {
        if (!$this->configs) {
            $this->init();
        }
    }

    public function get(string $key): array
    {
        return $this->configs[$key] ?? [];
    }

    private function init(): void
    {
        $rootDirectory = $_SERVER['DOCUMENT_ROOT'];

        $this->configs = [
            'routes' => include $rootDirectory . '/config/routes.php',
            'supermetrics_api' => include $rootDirectory . '/config/supermetrics_api.php'
        ];
    }
}