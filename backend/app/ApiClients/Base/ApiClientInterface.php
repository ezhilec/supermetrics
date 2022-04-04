<?php

namespace App\ApiClients\Base;

interface ApiClientInterface
{
    public function getPosts(int $page): ApiResponseInterface;
}