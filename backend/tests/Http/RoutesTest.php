<?php
namespace Tests\Http;

use App\CacheClients\Database\DatabaseCacheClient;
use App\DTOs\PostDTO;
use PHPUnit\Framework\TestCase;
use Exception;

class RoutesTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testPostsRoute(): void
    {
        $testPosts = [
            (new PostDTO())->fromDatabase([
                "slug" => "1",
                "user_name" => "user1",
                "user_slug" => "user1",
                "message" => "123",
                "type" => "",
                "created_at" => date("Y-m-d H:i:s"),
            ])
        ];

        $cacheClient = new DatabaseCacheClient();

        $cacheClient->beforeTests();

        $cacheClient->clearPosts();

        $cacheClient->setPosts($testPosts, false);

        $result = $this->getUrl("supermetrics-nginx/api/v1/posts");

        $httpCode = $result["code"];
        $response = $result["response"];

        $this->assertEquals(200, $httpCode);

        $this->assertEqualsCanonicalizing([
            "success",
            "data",
        ], array_keys($response));

        $this->assertEqualsCanonicalizing([
            "list",
            "page",
            "per_page",
            "total",
        ], array_keys($response["data"]));

        $firstPost = $response["data"]["list"][0] ?? null;

        $this->assertEqualsCanonicalizing([
            "id",
            "from_name",
            "from_id",
            "message",
            "type",
            "created_at"
        ], array_keys($firstPost));

        $cacheClient->afterTests();
    }

    /**
     * @return void
     */
    public function testWrongRoute(): void
    {
        $result = $this->getUrl("supermetrics-nginx/api/v1/wrong!");

        $httpCode = $result["code"];

        $this->assertEquals(404, $httpCode);
    }

    /**
     * @param $url
     * @return array
     */
    private function getUrl($url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);
        return [
            "code" => $httpCode,
            "response" => json_decode($response, true)
        ];
    }
}