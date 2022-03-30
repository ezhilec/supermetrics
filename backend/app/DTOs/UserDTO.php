<?php

namespace App\DTOs;

class UserDTO
{
    public string $id;
    public string $name;

    public function fromDatabase(array $data): UserDTO
    {
        $this->id = $data['user_slug'];
        $this->name = $data['user_name'];

        return $this;
    }
}