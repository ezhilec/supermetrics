<?php
namespace App\Controllers;

use App\ApiClients\SupermetricsApiClient;
use App\Requests\PostRequest;
use App\Views\JsonView;

class UserController
{
    public function index(array $request): void
    {
       // $apiClient = new SupermetricsApiClient();

        //$users = (new PostRequest($apiClient))->getUsers($request->page);

       // JsonView::render($users);
    }

    public function show(array $request): void
    {
        JsonView::render([
            'asd' => 'cdsa'
        ]);
    }
}