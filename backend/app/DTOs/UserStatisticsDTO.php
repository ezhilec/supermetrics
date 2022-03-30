<?php

namespace App\DTOs;

class UserStatisticsDTO
{
    public int $user_posts_count;
    public int $avg_message_length;
    public array $posts_by_month;
    public array $max_message_post;

    public function fromDatabase(array $data): UserStatisticsDTO
    {
        $this->user_posts_count = $data['user_posts_count'];
        $this->avg_message_length = $data['avg_message_length'];
        $this->posts_by_month = $data['posts_by_month'];
        $this->max_message_post = $data['max_message_post'];

        return $this;
    }

    public function toArray()
    {
        return [
            'user_posts_count' => $this->user_posts_count,
            'avg_message_length' => $this->avg_message_length,
            'posts_by_month' => $this->posts_by_month,
            'max_message_post' => $this->max_message_post,
        ];
    }
}