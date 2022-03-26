<?php

return [
    '/^\/posts$/' => [
        'name' => 'PostController',
        'method' => 'index'
    ],
    '/^\/users\/(?<userId>.+)$/' => [
        'name' => 'UserController',
        'method' => 'show'
    ],
    '/^\/users$/' => [
        'name' => 'UserController',
        'method' => 'index'
    ],
    '/^.*$/' => [
        'name' => 'ErrorController',
        'method' => 'show404'
    ]
];