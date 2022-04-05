<?php

namespace App\DTOs;

use DateTime;

class PostDTO
{
    use CollectionFromDatabaseTrait;

    public string $id;
    public string $from_name;
    public string $from_id;
    public string $message;
    public string $type;
    public string $created_at;

    private const DATE_FORMAT = 'd.m.Y H:i:s';

    public static function collectionFromSupermetricsAPI(array $array): array
    {
        return array_map(fn($item): self => (new self())->fromSupermetricsApi($item), $array);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fromSupermetricsApi(array $data): PostDTO
    {
        $createdAt = DateTime::createFromFormat(DateTime::ISO8601, $data['created_time']);

        $this->id = $data['id'];
        $this->from_name = $data['from_name'];
        $this->from_id = $data['from_id'];
        $this->message = $data['message'];
        $this->type = $data['type'];
        $this->created_at = $createdAt->format($this::DATE_FORMAT);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fromDatabase(array $data): PostDTO
    {
        $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at']);

        $this->id = $data['slug'];
        $this->from_name = $data['user_name'];
        $this->from_id = $data['user_slug'];
        $this->message = $data['message'];
        $this->type = $data['type'];
        $this->created_at = $createdAt->format($this::DATE_FORMAT);

        return $this;
    }

    /**
     * @return array
     */
    public function toDatabaseArray(): array
    {
        $createdAt = DateTime::createFromFormat($this::DATE_FORMAT, $this->created_at);

        return [
            'slug' => $this->id,
            'user_name' => $this->from_name,
            'user_slug' => $this->from_id,
            'message' => $this->message,
            'type' => $this->type,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
        ];
    }
}