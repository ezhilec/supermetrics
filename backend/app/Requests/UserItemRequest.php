<?php

namespace App\Requests;

class UserItemRequest
{
    public string $slug = '';
    public int $limit = 0;

    public function __construct($params)
    {
        if (isset($params['userId'])) {
            $this->slug = $params['userId'];
        }

        if (isset($params['limit'])) {
            $this->limit = $params['limit'];
        }
    }
}