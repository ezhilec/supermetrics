<?php

namespace App\DTOs;

class PostDTO
{
    public string $id;
    public string $fromName;
    public string $fromId;
    public string $message;
    public string $type;
    public string $createdTime;

    // todo replace to hydrator
    public function fromArray(array $data): PostDTO
    {
        $this->id = $data['id'];
        $this->fromName = $data['from_name'];
        $this->fromId = $data['from_id'];
        $this->message = $data['message'];
        $this->type = $data['type'];
        $this->createdTime = $data['created_time'];

        return $this;
    }
}