<?php

namespace App\Services;

use App\ApiClients\ApiClientInterface;
use App\CacheClients\CacheClientInterface;
use App\DTOs\PostDTO;
use App\DTOs\UserDTO;
use App\DTOs\UserStatisticsDTO;

class PostService
{
    private CacheClientInterface $cacheClient;
    private ApiClientInterface $apiClient;

    public function __construct(
        CacheClientInterface $cacheClient,
        ApiClientInterface $apiClient,
    ) {
        $this->cacheClient = $cacheClient;
        $this->apiClient = $apiClient;

        $this->synchronizeCache();
    }

    public function getPosts($page = 1): array
    {
        $posts = $this->cacheClient->getPosts(100, ($page - 1) * 100);
        return array_map(fn($item) => (new PostDTO())->fromDatabase($item), $posts);
    }

    public function getPostsUsers($page = 1): array
    {
        $posts = $this->cacheClient->getUsers(100, ($page - 1) * 100);
        return array_map(fn($item) => (new UserDTO())->fromDatabase($item), $posts);
    }

    public function getUserStatistics(string $slug): array
    {
        $userItem = $this->cacheClient->getUserStatistics($slug, 1000); // todo limit from config
        return (new UserStatisticsDTO())->fromDatabase($userItem)->toArray();
    }

    private function synchronizeCache(): void
    {
        $postsLimit = 1000; // todo get from config
        $page = 1;

        $result = [];

        $lastCachedPost = $this->cacheClient->getPosts(1, 0)[0] ?? null;
        if ($lastCachedPost) {
            $lastCachedPostId = (new PostDTO())->fromDatabase($lastCachedPost)->id;
        }

        while (count($result) < $postsLimit) {
            $apiPosts = $this->apiClient->getPosts($page)->getData()['posts'];

            if ($lastCachedPost) {
                $cachedIdInApiPostsPosition = array_search($lastCachedPostId, array_column($apiPosts, 'id'));
                if ($cachedIdInApiPostsPosition !== -1) {
                    $apiPosts = array_slice($apiPosts, 0, $cachedIdInApiPostsPosition, true);
                }
            }

            if ($apiPosts) {
                $posts = array_map(fn($item) => (new PostDTO())->fromSupermetricsApi($item), $apiPosts);
                $result = array_merge($result, $posts);
                $this->cacheClient->setPosts($posts);
            }

            if ($lastCachedPost && $cachedIdInApiPostsPosition !== -1) {
                break;
            }
            $page++;
        }
    }
}