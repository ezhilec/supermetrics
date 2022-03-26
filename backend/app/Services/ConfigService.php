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
        $this->configs = [
            'routes' => include $_SERVER['DOCUMENT_ROOT'] . '/config/routes.php'
        ];
    }
}