<?php

namespace App\DTOs;

class PostDTO
{
    public string $id;
    public string $from_name;
    public string $from_id;
    public string $message;
    public string $type;
    public string $created_at;

    public function fromSupermetricsApi(array $data): PostDTO
    {
        $this->id = $data['id'];
        $this->from_name = $data['from_name'];
        $this->from_id = $data['from_id'];
        $this->message = $data['message'];
        $this->type = $data['type'];
        $this->created_at = $data['created_time'];

        return $this;
    }

    public function fromDatabase(array $data): PostDTO
    {
        $this->id = $data['slug'];
        $this->from_name = $data['user_name'];
        $this->from_id = $data['user_slug'];
        $this->message = $data['message'];
        $this->type = $data['type'];
        $this->created_at = $data['created_at'];

        return $this;
    }

    public function toDatabaseArray(): array
    {
        return [
            'slug' => $this->id,
            'user_name' => $this->from_name,
            'user_slug' => $this->from_id,
            'message' => $this->message,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ];
    }
}