<?php

namespace DAO\Posts;

require_once __DIR__ . "/../../../database/databaseConnector.php";
require_once __DIR__ . "/PostDAO.php";
require_once __DIR__ . "/../Tags/TagDAOImpl.php";

use DAO\Tags\TagDAOImpl;
use database\databaseConnector;

class PostDAOImpl implements PostDAO
{
    private $connection;
    private $tagDAO;

    /**
     * @throws \dbConnectException
     */
    public function __construct()
    {
        $this->tagDAO = new TagDAOImpl();
        $db = new databaseConnector();
        try {
            $this->connection = $db->createConnection();
        } catch (\PDOException $e) {
            throw new \dbConnectException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Получает все записи из таблицы posts.
     *
     * @return array Возвращает массив всех записей из таблицы posts.
     */
    public function getAll(string $sort = 'desc'): array
    {
        $sortOrder = strtolower($sort) === 'asc' ? 'ASC' : 'DESC';

        $query = "
        SELECT posts.*, users.username, GROUP_CONCAT(tags.name) AS tags
        FROM posts
        JOIN users ON posts.user_id = users.id
        LEFT JOIN post_tags ON posts.id = post_tags.post_id
        LEFT JOIN tags ON post_tags.tag_id = tags.id
        GROUP BY posts.id
        ORDER BY posts.created_at $sortOrder
    ";

        return $this->connection
            ->query($query)
            ->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Создает новую запись в таблице posts.
     *
     * @param string $title Заголовок поста.
     * @param string $content Содержимое поста.
     * @param string|null $photo_path Путь к изображению (опционально).
     * @param string|null $file_path Путь к файлу (опционально).
     * @return bool Возвращает true, если запись успешно создана, иначе false.
     */
    public function create($title, $content, ?string $photo_path,?string $file_path, ?array $tags = []): bool
    {
        $sql = "INSERT INTO posts (title, content, created_at, photo_path, file_path, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $created_at = date("Y-m-d H:i:s");
        $user_id = $_SESSION["user_id"] ?? null;

        if (!$user_id) return false;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$title, $content, $created_at, $photo_path, $file_path, $user_id]);

        $post_id = $this->connection->lastInsertId();

        if (!empty($tags)) {
                foreach ($tags as $tag_id) {
                    $this->addTagToPost((int)$post_id, (int)$tag_id);
                }
        }

        return true;
    }

    public function update($id, $title, $content, $photo_path, $file_path, ?array $tags = [])
    {
        $sql = "UPDATE posts SET title = ?, content = ?, photo_path = ?, file_path = ? WHERE id = ?";
        $this->connection->prepare($sql)->execute([$title, $content, $photo_path, $file_path, $id]);


        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $this->addTagToPost((int)$id, (int)$tag_id);
            }
        }
        return true;
    }

    /**
     * Находит пост по ID с подгрузкой тегов.
     *
     * @param int $id ID поста.
     * @return array|null Возвращает данные поста и список тегов или null, если не найден.
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, t.name AS tag_name
                FROM posts p
                LEFT JOIN post_tags pt ON p.id = pt.post_id
                LEFT JOIN tags t ON pt.tag_id = t.id
                WHERE p.id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($rows)) return null;

        $post = [
            'id' => $rows[0]['id'],
            'title' => $rows[0]['title'],
            'content' => $rows[0]['content'],
            'created_at' => $rows[0]['created_at'],
            'photo_path' => $rows[0]['photo_path'],
            'file_path' => $rows[0]['file_path'],
            'user_id' => $rows[0]['user_id'],
            'tags' => [],
        ];

        foreach ($rows as $row) {
            if (!empty($row['tag_name'])) {
                $post['tags'][] = $row['tag_name'];
            }
        }

        return $post;
    }


    public function searchPostsByTags(array $tagIds): array
    {
        $placeholders = implode(',', array_fill(0, count($tagIds), '?')); // создаем плейсхолдеры для тэгов
        $sql = "
            SELECT p.*, GROUP_CONCAT(t.name) AS tags
            FROM posts p
            LEFT JOIN post_tags pt ON p.id = pt.post_id
            LEFT JOIN tags t ON pt.tag_id = t.id
            WHERE t.id IN ($placeholders)
            GROUP BY p.id
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($tagIds);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM post_tags WHERE post_id = ?");
        $stmt->execute([$id]);

        $stmt = $this->connection->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }


    public function addTagToPost(?int $post_id,?int $tag_id)
    {
        if (is_null($post_id) || is_null($tag_id)) {
            return;
        }
        $sql = "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$post_id, $tag_id]);
    }

    public function searchByTitle($title)
    {
        $query = '%' . $title . '%';
        $sql = "SELECT * FROM posts WHERE title LIKE ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$query]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
