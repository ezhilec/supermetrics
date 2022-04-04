<?php

namespace App\Requests;

class PaginatedRequest
{
    public int $page = 1;
    public int $perPage = 20;

    public function __construct($params)
    {
        if (isset($params['page'])) {
            $this->page = $params['page'];
        }

        if (isset($params['perPage'])) {
            $this->perPage = $params['perPage'];
        }
    }
}