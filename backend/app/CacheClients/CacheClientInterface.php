<?php

namespace App\CacheClients;

interface CacheClientInterface
{
    public function getPosts(int $limit, int $offset): array;

    public function setPosts(array $data): void;

    public function getUsers(int $limit, int $offset): array;

    public function getUserStatistics(string $slug, int $limit): array;

    public function beforeTests(): void;

    public function afterTests(): void;
}