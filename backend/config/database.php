<?php

return [
    "host" => getenv("database_host"),
    "database" => getenv("database_database"),
    "user" => getenv("database_user"),
    "password" => getenv("database_password"),
    "charset" => "utf8"
];