<?php

namespace App\Controllers;

use App\ApiClients\BaseApiClient;
use App\ApiClients\SupermetricsApiClient;
use App\CacheClients\CacheClientInterface;
use App\CacheClients\DatabaseCacheClient;
use App\Requests\PostRequest;
use App\Services\PostService;
use App\Views\JsonView;

class PostController
{
    private CacheClientInterface $cacheClient;
    private BaseApiClient $apiClient;

    public function __construct()
    {
        $this->cacheClient = new DatabaseCacheClient();
        $this->apiClient = new SupermetricsApiClient();
    }

    public function index(array $params): void
    {
        $request = new PostRequest($params);

        $posts = (new PostService($this->cacheClient, $this->apiClient))->getPosts($request->page);

        JsonView::render($posts);
    }
}