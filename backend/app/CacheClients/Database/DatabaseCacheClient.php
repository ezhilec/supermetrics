<?php

namespace App\CacheClients\Database;

use App\CacheClients\CacheClientInterface;
use Exception;
use PDO;

class DatabaseCacheClient implements CacheClientInterface
{
    private PDO $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->db = Database::instance();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getPosts(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT ? OFFSET ?;";

        $result = $this->db->prepare($sql);
        $result->execute([$limit, $offset]);
        return $result->fetchAll();
    }

    public function clearPosts(): void
    {
        $this->db->prepare("DELETE FROM posts")->execute();
    }

    /**
     * @return int
     */
    public function getPostsCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM posts;";

        $result = $this->db->prepare($sql);
        $result->execute();
        return $result->fetchColumn();
    }

    /**
     * @param array $data
     * @param bool $useTransactions
     * @return void
     * @throws Exception
     */
    public function setPosts(array $data, bool $useTransactions = true): void
    {
        $sql = "INSERT INTO posts 
                (slug, user_name, user_slug, message, type, created_at) 
                VALUES (:slug, :user_name, :user_slug, :message, :type, :created_at)
                ON DUPLICATE KEY UPDATE slug = slug;";

        $result = $this->db->prepare($sql);

        if ($useTransactions) {
            try {
                $this->db->beginTransaction();
                foreach ($data as $postDTO) {
                    $result->execute($postDTO->toDatabaseArray());
                }
                $this->db->commit();
            } catch (Exception $e) {
                $this->db->rollback();
                throw $e;
            }
        } else {
            foreach ($data as $postDTO) {
                $result->execute($postDTO->toDatabaseArray());
            }
        }
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getUsers(int $limit, int $offset): array
    {
        $sql = "SELECT MAX(user_name) as user_name, user_slug 
                FROM posts 
                GROUP BY user_slug 
                ORDER BY user_name 
                LIMIT ? OFFSET ?;";

        $result = $this->db->prepare($sql);
        $result->execute([$limit, $offset]);
        return $result->fetchAll();
    }

    /**
     * @return int
     */
    public function getUsersCount(): int
    {
        $sql = "SELECT COUNT(DISTINCT user_slug) as total FROM posts;";

        $result = $this->db->prepare($sql);
        $result->execute();
        return $result->fetchColumn();
    }

    public function getUser(string $slug): array
    {
        $sql = "SELECT user_name, user_slug 
                FROM posts 
                WHERE user_slug = ?
                LIMIT 1;";

        $result = $this->db->prepare($sql);
        $result->execute([$slug]);
        return $result->fetchAll()[0] ?? [];
    }

    /**
     * @return void
     */
    public function beforeTests(): void
    {
        $this->db->beginTransaction();
    }

    /**
     * @return void
     */
    public function afterTests(): void
    {
        $this->db->rollback();
    }

    /**
     * @param string $slug
     * @param int $limit
     * @return int
     */
    public function getUserPostsCount(string $slug, int $limit): int
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

    /**
     * @param string $slug
     * @param int $limit
     * @return int
     */
    public function getUserAvgMessageLength(string $slug, int $limit): int
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

    /**
     * @param string $slug
     * @param int $limit
     * @return array
     */
    public function getUserPostsByMonth(string $slug, int $limit): array
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

    /**
     * @param string $slug
     * @param int $limit
     * @return array
     */
    public function getUserMaxMessagePost(string $slug, int $limit): array
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