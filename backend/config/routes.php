<?php

return [
    "/^\/posts$/" => [
        "name" => "PostController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "index"
    ],
    "/^\/users\/(?<userId>.+)$/" => [
        "name" => "UserController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "show"
    ],
    "/^\/users$/" => [
        "name" => "UserController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "index"
    ],
    "/^.*$/" => [
        "name" => "ErrorController",
        "method" => "show404"
    ]
];