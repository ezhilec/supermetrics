<?php

namespace App\Resources;

class PaginatedResource
{
    public array $list;
    public int $page;
    public int $perPage;
    public int $total;

    /**
     * @param array $list
     * @return $this
     */
    public function setList(array $list): PaginatedResource
    {
        $this->list = $list;

        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setPage(int $page): PaginatedResource
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setPerPage(int $perPage): PaginatedResource
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal(int $total): PaginatedResource
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'list' => $this->list,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'total' => $this->total
        ];
    }
}