<?php

namespace App\ApiClients;

interface ApiClientInterface
{
    public function getPosts(int $page): ApiResponseInterface;
}