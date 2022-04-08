<?php

namespace App\Controllers;

use App\ApiClients\Base\ApiClientInterface;
use App\CacheClients\CacheClientInterface;
use App\Requests\PostRequest;
use App\Resources\PostsResource;
use App\Services\PostService;
use App\Views\JsonView;

class PostController
{
    private PostService $postsService;

    public function __construct(
        CacheClientInterface $cacheClient,
        ApiClientInterface $apiClient
    ) {
        $this->postsService = new PostService($cacheClient, $apiClient);
    }

    /**
     * @param array $params
     * @return void
     */
    public function index(array $params): void
    {
        $request = new PostRequest($params);

        $posts = $this->postsService->getPosts($request->page, $request->perPage);
        $count = $this->postsService->getPostsCount();

        $result = (new PostsResource())
            ->setList($posts)
            ->setPage($request->page)
            ->setPerPage($request->perPage)
            ->setTotal($count)
            ->toArray();

        JsonView::render(true, $result);
    }
}