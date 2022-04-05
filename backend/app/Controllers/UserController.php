<?php

namespace App\Controllers;

use App\ApiClients\Base\ApiClientInterface;
use App\ApiClients\Supermetrics\SupermetricsApiClient;
use App\CacheClients\CacheClientInterface;
use App\CacheClients\Database\DatabaseCacheClient;
use App\Requests\UserItemRequest;
use App\Requests\UserRequest;
use App\Resources\UsersResource;
use App\Services\ConfigService;
use App\Services\PostService;
use App\Views\JsonView;

class UserController
{
    private CacheClientInterface $cacheClient;
    private ApiClientInterface $apiClient;
    private PostService $postsService;

    public function __construct()
    {
        $this->cacheClient = new DatabaseCacheClient();
        $this->apiClient = new SupermetricsApiClient();
        $this->postsService = new PostService($this->cacheClient, $this->apiClient);
    }

    /**
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        $request = new UserRequest($params);

        $users = $this->postsService->getPostsUsers($request->page, $request->perPage);
        $count = $this->postsService->getPostsUsersCount();

        $result = (new UsersResource())
            ->setList($users)
            ->setPage($request->page)
            ->setPerPage($request->perPage)
            ->setTotal($count)
            ->toArray();

        JsonView::render($result);
    }

    /**
     * @param array $params
     * @return void
     */
    public function show(array $params): void
    {
        $request = new UserItemRequest($params);

        $postsLimit = ConfigService::getInstance()->get('posts')['fetch_limit'];

        $userStatistics = $this->postsService->getUserStatistics($request->slug, $postsLimit);

        JsonView::render($userStatistics);
    }
}