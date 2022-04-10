<?php

namespace App\CacheClients;

interface TestableCacheClientInterface
{
    public function beforeTests(): void;

    public function afterTests(): void;
}