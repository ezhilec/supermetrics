<?php

namespace App\CacheClients;

interface CacheClientInterface
{
    public function getPosts(int $limit, int $offset): array;

    public function setPosts(array $data): void;

    public function getUsers(int $limit, int $offset): array;

    public function getUser(string $slug): array;

    public function getUserPostsCount(string $slug, int $limit): int;

    public function getUserAvgMessageLength(string $slug, int $limit): int;

    public function getUserPostsByMonth(string $slug, int $limit): array;

    public function getUserMaxMessagePost(string $slug, int $limit): array;

    public function beforeTests(): void;

    public function afterTests(): void;
}