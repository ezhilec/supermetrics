<?php

namespace App\DTOs;

class UserStatisticsDTO
{
    public ?UserDTO $user;
    public int $user_posts_count;
    public int $avg_message_length;
    public array $posts_by_month;
    public ?PostDTO $max_message_post;

    /**
     * @param array $data
     * @return $this
     */
    public function fromDatabase(array $data): UserStatisticsDTO
    {
        $this->user = $data['user']
            ? (new UserDTO())->fromDatabase($data['user'])
            : null;
        $this->user_posts_count = $data['user_posts_count'];
        $this->avg_message_length = $data['avg_message_length'];
        $this->posts_by_month = $data['posts_by_month'];
        $this->max_message_post = isset($data['max_message_post'][0])
            ? (new PostDTO())->fromDatabase($data['max_message_post'][0])
            : null;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'user_posts_count' => $this->user_posts_count,
            'avg_message_length' => $this->avg_message_length,
            'posts_by_month' => $this->posts_by_month,
            'max_message_post' => $this->max_message_post,
        ];
    }
}