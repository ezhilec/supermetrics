<?php

const API_PREFIX = "\/api\/v1";

return [
    "/^" . API_PREFIX . "\/posts$/" => [
        "name" => "PostController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "index"
    ],
    "/^" . API_PREFIX . "\/users\/(?<userId>.+)$/" => [
        "name" => "UserController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "show"
    ],
    "/^" . API_PREFIX . "\/users$/" => [
        "name" => "UserController",
        "bindings" => ["cacheClient", "apiClient"],
        "method" => "index"
    ],
    "/^.*$/" => [
        "name" => "ErrorController",
        "method" => "show404"
    ]
];