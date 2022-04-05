<?php

namespace Tests\Feature;

use App\CacheClients\Database\DatabaseCacheClient;
use App\DTOs\PostDTO;
use App\Services\PostService;
use PHPUnit\Framework\TestCase;

class PostServiceTest extends TestCase
{
    /**
     * @return void
     * @throws \Exception
     */
    public function testUserStatistics(): void
    {
        $testPosts = [
            [
                'slug' => '1',
                'user_name' => 'user1',
                'user_slug' => 'user1',
                'message' => '123',
                'type' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => '2',
                'user_name' => 'user2',
                'user_slug' => 'user2',
                'message' => '1234',
                'type' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => '3',
                'user_name' => 'user1',
                'user_slug' => 'user1',
                'message' => '12345',
                'type' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => '4',
                'user_name' => 'user1',
                'user_slug' => 'user1',
                'message' => '123456',
                'type' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => '5',
                'user_name' => 'user1',
                'user_slug' => 'user1',
                'message' => '12',
                'type' => '',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($testPosts as &$post) {
            $post = (new PostDTO())->fromDatabase($post);
        }

        $cacheClient = new DatabaseCacheClient();

        $cacheClient->beforeTests();

        $cacheClient->clearPosts();

        $cacheClient->setPosts($testPosts, false);

        $userName = 'user1';

        $postService = new PostService($cacheClient);
        $result = $postService->getUserStatistics($userName, 1000);

        $userPosts = array_filter($testPosts, fn($item): bool => $item->from_id === $userName);

        $expectedUserPostsCount = count($userPosts);
        $this->assertEquals($result["user_posts_count"], $expectedUserPostsCount);

        $messageLengthArray = array_map(fn($item): int => strlen($item->message), $userPosts);
        $expectedAvgMessageLength = round(array_sum($messageLengthArray) / $expectedUserPostsCount);
        $this->assertEquals($result["avg_message_length"], $expectedAvgMessageLength);

        $this->assertEqualsCanonicalizing([
            'month' => date('m.Y'),
            'posts_count' => $expectedUserPostsCount
        ], $result["posts_by_month"][0]);

        $maxPostIndex = array_search(max($messageLengthArray), $messageLengthArray);
        $this->assertEquals($result["max_message_post"], $userPosts[$maxPostIndex]);

        $cacheClient->afterTests();
    }
}