<?php
namespace App\Controllers;

use App\ApiClients\BaseApiClient;
use App\ApiClients\SupermetricsApiClient;
use App\CacheClients\CacheClientInterface;
use App\CacheClients\DatabaseCacheClient;
use App\Requests\UserItemRequest;
use App\Requests\UserRequest;
use App\Services\PostService;
use App\Views\JsonView;

class UserController
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
        $request = new UserRequest($params);

        $posts = (new PostService($this->cacheClient, $this->apiClient))
            ->getPostsUsers($request->page);

        JsonView::render($posts);
    }

    public function show(array $params): void
    {
        $request = new UserItemRequest($params);

        $userStatistics = (new PostService($this->cacheClient, $this->apiClient))
            ->getUserStatistics($request->slug, 1000);

        JsonView::render($userStatistics);
    }
}