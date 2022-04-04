<?php

namespace App\Services;

use App\ApiClients\Base\ApiClientInterface;
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

        if (ConfigService::getInstance()->get('supermetrics_api')['allow_connect']) {
            $this->synchronizeCache();
        }
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getPosts(int $page = 1, int $perPage = 20): array
    {
        $posts = $this->cacheClient->getPosts($perPage, self::getOffset($page, $perPage));

        return PostDTO::collectionFromDatabase($posts);
    }

    /**
     * @return int
     */
    public function getPostsCount(): int
    {
        $postsLimit = ConfigService::getInstance()->get('posts')['fetch_limit'];
        $postsCount = $this->cacheClient->getPostsCount();

        return min($postsCount, $postsLimit);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getPostsUsers(int $page = 1, int $perPage = 5): array
    {
        $users = $this->cacheClient->getUsers($perPage, self::getOffset($page, $perPage));

        return UserDTO::collectionFromDatabase($users);
    }

    /**
     * @return int
     */
    public function getPostsUsersCount(): int
    {
        return $this->cacheClient->getUsersCount();
    }

    /**
     * @param string $slug
     * @param int $limit
     * @return array
     */
    public function getUserStatistics(string $slug, int $limit): array
    {
        $userItem = $this->cacheClient->getUserStatistics($slug, $limit);

        return (new UserStatisticsDTO())->fromDatabase($userItem)->toArray();
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return int
     */
    private static function getOffset(int $page, int $perPage): int
    {
        return ($page - 1) * $perPage;
    }

    /**
     * @return PostDTO|null
     */
    private function getLastCachedPost(): ?PostDTO
    {
        $lastCachedPost = $this->cacheClient->getPosts(1, 0)[0] ?? null;

        if ($lastCachedPost) {
            return (new PostDTO())->fromDatabase($lastCachedPost);
        }

        return null;
    }

    /**
     * @return void
     */
    private function synchronizeCache(): void
    {
        $postsLimit = ConfigService::getInstance()->get('posts')['fetch_limit'];
        $page = 1;
        $result = [];

        $lastCachedPost = $this->getLastCachedPost();

        while (count($result) < $postsLimit) {
            $apiPosts = $this->apiClient->getPosts($page)->getData()['posts'];

            if ($lastCachedPost) {
                $cachedIdInApiPostsPosition = array_search($lastCachedPost->id, array_column($apiPosts, 'id'));

                if ($cachedIdInApiPostsPosition !== false) {
                    $apiPosts = array_slice($apiPosts, 0, $cachedIdInApiPostsPosition, true);
                }
            }

            if ($apiPosts) {
                $postsToSave = PostDTO::collectionFromSupermetricsAPI($apiPosts);
                $result = array_merge($result, $postsToSave);
                $this->cacheClient->setPosts($postsToSave);
            } else {
                break;
            }

            if ($lastCachedPost && $cachedIdInApiPostsPosition !== false) {
                break;
            }
            $page++;
        }
    }
}