<?php

namespace App\DTOs;

class UserDTO
{
    use CollectionFromDatabaseTrait;

    public string $id;
    public string $name;

    /**
     * @param array $data
     * @return $this
     */
    public function fromDatabase(array $data): UserDTO
    {
        $this->id = $data['user_slug'];
        $this->name = $data['user_name'];

        return $this;
    }
}