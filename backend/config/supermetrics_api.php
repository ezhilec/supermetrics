<?php

return [
    "allow_connect" => true,
    "host" => getenv("supermetrics_api_host"),
    "auth_path" => getenv("supermetrics_api_auth_path"),
    "posts_path" => getenv("supermetrics_api_posts_path"),
    "client_id" => getenv("supermetrics_api_client_id"),
    "email" => getenv("supermetrics_api_email"),
    "name" => getenv("supermetrics_api_name"),
];