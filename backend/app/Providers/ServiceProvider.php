<?php

namespace App\Providers;

use App\ApiClients\Supermetrics\SupermetricsApiClient;
use App\CacheClients\Database\DatabaseCacheClient;

class ServiceProvider
{
    private static array $bindings = [
            "cacheClient" => DatabaseCacheClient::class,
            "apiClient" => SupermetricsApiClient::class,
    ];

    /**
     * @param array $names
     * @return array
     */
    public static function getBindings(array $names): array
    {
        $filteredBindings = array_filter(
            self::$bindings,
            fn($name): bool => in_array($name, $names),
            ARRAY_FILTER_USE_KEY
        );

        return array_map(fn($class) => new $class, $filteredBindings);
    }
}