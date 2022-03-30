<?php

namespace App\CacheClients;

use \PDO;

class DatabaseCacheClient implements CacheClientInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getPosts(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM `posts` ORDER BY `created_at` DESC LIMIT ? OFFSET ?;";

        $result = $this->db->prepare($sql);
        $result->execute([$limit, $offset]);
        return $result->fetchAll();
    }

    public function setPosts(array $data): void
    {
        $sql = "INSERT INTO `posts` 
                (`slug`, `user_name`, `user_slug`, `message`, `type`, `created_at`) 
                VALUES (:slug, :user_name, :user_slug, :message, :type, :created_at)
                ON DUPLICATE KEY UPDATE id = id;";

        $result = $this->db->prepare($sql);

        try {
            $this->db->beginTransaction();
            foreach ($data as $postDTO) {
                $result->execute($postDTO->toDatabaseArray());
            }
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function getUsers(int $limit, int $offset): array {
        $sql = "SELECT MAX(user_name) as user_name, user_slug 
                FROM posts 
                GROUP BY user_slug 
                ORDER BY user_name 
                LIMIT ? OFFSET ?;";

        $result = $this->db->prepare($sql);
        $result->execute([$limit, $offset]);
        return $result->fetchAll();
    }

    public function getUserStatistics(string $slug, int $limit): array
    {
        return [
            'user_posts_count' => $this->getUserPostsCount($slug, $limit),
            'avg_message_length' => $this->getUserAvgMessageLength($slug, $limit),
            'posts_by_month' => $this->getUserPostsByMonth($slug, $limit),
            'max_message_post' => $this->getUserMaxMessagePost($slug, $limit),
        ];
    }

    private function getUserPostsCount(string $slug, int $limit): int
    {
        $sql = "
        SELECT COUNT(*) as posts_count
        FROM (SELECT * FROM posts ORDER BY created_at DESC LIMIT ?) limited_posts
        WHERE user_slug = ?;
        ";
        $result = $this->db->prepare($sql);
        $result->execute([$limit, $slug]);
        return $result->fetchColumn();
    }

    private function getUserAvgMessageLength(string $slug, int $limit): int
    {
        $sql = "
        SELECT ROUND(AVG(LENGTH(message))) as avg_message_length
        FROM (SELECT * FROM posts ORDER BY created_at DESC LIMIT ?) limited_posts
        WHERE user_slug = ?;
        ";
        $result = $this->db->prepare($sql);
        $result->execute([$limit, $slug]);
        return $result->fetchColumn() ?? 0;
    }

    private function getUserPostsByMonth(string $slug, int $limit): array
    {
        $sql = "
        SELECT DATE_FORMAT(created_at, '%m.%Y') as month, COUNT(*) as posts_count
        FROM (SELECT * FROM posts ORDER BY created_at DESC LIMIT ?) limited_posts
        WHERE user_slug = ?
        GROUP BY DATE_FORMAT(created_at, '%m.%Y');
        ";
        $result = $this->db->prepare($sql);
        $result->execute([$limit, $slug]);
        return $result->fetchAll();
    }

    private function getUserMaxMessagePost(string $slug, int $limit): array
    {
        $sql = "
        SELECT *, LENGTH(message) AS message_length
        FROM (SELECT * FROM posts ORDER BY created_at DESC LIMIT ?) limited_posts
        WHERE user_slug = ?
        ORDER BY message_length DESC
        LIMIT 1;
        ";
        $result = $this->db->prepare($sql);
        $result->execute([$limit, $slug]);
        return $result->fetchAll();
    }
}