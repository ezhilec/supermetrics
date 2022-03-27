<?php

namespace App\Controllers;

use App\ApiClients\SupermetricsApiClient;
use App\Requests\PostRequest;
use App\Services\ConfigService;
use App\Services\PostService;
use App\Views\JsonView;

class PostController
{
    public function index(array $params): void
    {
        $apiClient = new SupermetricsApiClient();

        $request = new PostRequest($params);

        //$posts = (new PostService($apiClient))->getAllPosts(1000);
        $posts = (new PostService($apiClient))->getPosts($request->page);

        JsonView::render($posts);
    }
}