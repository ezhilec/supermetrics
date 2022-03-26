<?php
namespace App\Controllers;

class PostController
{
    public function index(array $request): void
    {
        echo 'posts page' . $request['page'];
    }
}