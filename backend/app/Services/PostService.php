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
    private ?ApiClientInterface $apiClient;

    public function __construct(
        CacheClientInterface $cacheClient,
        ?ApiClientInterface $apiClient = null,
    ) {
        $this->cacheClient = $cacheClient;
        $this->apiClient = $apiClient;

        if ($apiClient && ConfigService::instance()->get("supermetrics_api.allow_connect")) {
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
        $postsLimit = ConfigService::instance()->get("posts.fetch_limit");
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
        $statisticsArray = [
            "user" => $this->cacheClient->getUser($slug),
            "user_posts_count" => $this->cacheClient->getUserPostsCount($slug, $limit),
            "avg_message_length" => $this->cacheClient->getUserAvgMessageLength($slug, $limit),
            "posts_by_month" => $this->cacheClient->getUserPostsByMonth($slug, $limit),
            "max_message_post" => $this->cacheClient->getUserMaxMessagePost($slug, $limit),
        ];

        return (new UserStatisticsDTO())->fromDatabase($statisticsArray)->toArray();
    }

    /**
     * @param array $posts
     * @param int $index
     * @return array
     */
    private function cutPostsAfterIndex(array $posts, int $index): array
    {
        return array_slice($posts, 0, $index, true);
    }

    /**
     * @param array $posts
     * @param PostDTO $post
     * @return int|bool
     */
    private function findPostInArray(array $posts, PostDTO $post): int|bool
    {
        return array_search($post->id, array_column($posts, "id"));
    }

    /**
     * @param array $posts
     * @return void
     */
    private function savePosts(array $posts): void
    {
        $this->cacheClient->setPosts($posts);
    }

    /**
     * @return void
     */
    private function synchronizeCache(): void
    {
        $postsLimit = ConfigService::instance()->get("posts.fetch_limit");
        $page = 1;
        $savedPostsCount = 0;

        $lastCachedPost = $this->getLastCachedPost();

        while ($savedPostsCount < $postsLimit) {
            $apiPosts = $this->apiClient->getPosts($page)->getData()["posts"];
            $cachedPostIndexInArray = false;

            if ($lastCachedPost) {
                $cachedPostIndexInArray = $this->findPostInArray($apiPosts, $lastCachedPost);
                if ($cachedPostIndexInArray !== false) {
                    $apiPosts = $this->cutPostsAfterIndex($apiPosts, $cachedPostIndexInArray);
                }
            }

            if ($apiPosts) {
                $postsToSave = PostDTO::collectionFromSupermetricsAPI($apiPosts);
                $this->savePosts($postsToSave);
                $savedPostsCount += count($postsToSave);
            } else {
                break;
            }

            if ($cachedPostIndexInArray !== false) {
                break;
            }
            $page++;
        }
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
     * @param int $page
     * @param int $perPage
     * @return int
     */
    private static function getOffset(int $page, int $perPage): int
    {
        return ($page - 1) * $perPage;
    }
}