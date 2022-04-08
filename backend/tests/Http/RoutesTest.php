<?php
namespace Tests\Http;

use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    public function testPostsRoute()
    {
        $result = $this->getUrl("supermetrics-nginx/posts");

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
            "perPage",
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
    }

    public function testWrongRoute()
    {
        $result = $this->getUrl("supermetrics-nginx/wrong!");

        $httpCode = $result["code"];

        $this->assertEquals(404, $httpCode);
    }

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