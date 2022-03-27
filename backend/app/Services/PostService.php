<?php

namespace App\Services;

use App\ApiClients\ApiClientInterface;
use App\ApiClients\SupermetricsApiClient;
use App\DTOs\PostDTO;

class PostService
{
    private ApiClientInterface $apiClient;

    public function __construct(SupermetricsApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getPosts($page = 1): array
    {
        $response = $this->apiClient->getPosts($page);
        $responseData = $response->getData();

        return array_map(fn($item) => (new PostDTO())->fromArray($item), $responseData['posts']);
    }

    public function getAllPosts(int $postsLimit = 250): array
    {
        $result = [];
        $page = 1;

        while (count($result) < $postsLimit) {
            $posts = $this->getPosts($page);

            $result = array_merge($result, $posts);
            $page++;
        }

        return array_slice($result, 0, $postsLimit);
    }
}