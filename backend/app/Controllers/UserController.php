<?php
namespace App\Controllers;

use App\Views\JsonView;

class UserController
{
    public function index(array $request): void
    {
        echo 'users page';
    }

    public function show(array $request): void
    {
        //var_dump($request);
       // echo 'user dashboard page';
        JsonView::render([
            'asd' => 'cdsa'
        ]);
    }
}