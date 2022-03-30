<?php

namespace App\Requests;

class PaginatedRequest
{
    public int $page = 1;

    public function __construct($params)
    {
        if (isset($params['page'])) {
            $this->page = $params['page'];
        }
    }
}