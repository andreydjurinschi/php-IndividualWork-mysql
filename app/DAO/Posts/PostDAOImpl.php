<?php

namespace DAO\Posts;

require_once __DIR__ . "/../../../database/databaseConnector.php";
require_once __DIR__ . "/PostDAO.php";

use database\databaseConnector;

class PostDAOImpl implements PostDAO
{
    private $connection;

    /**
     * @throws \dbConnectException
     */
    public function __construct()
    {
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
    public function getAll(): array
    {
        return $this->connection
            ->query("SELECT posts.*, users.username FROM posts
                           JOIN users ON posts.user_id = users.id
                           ORDER BY posts.created_at DESC")
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
    public function create( $title,  $content, ?string $photo_path = null, ?string $file_path = null): bool
    {
        $sql = "INSERT INTO posts (title, content, created_at, photo_path, file_path, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $created_at = date("Y-m-d H:i:s");
        $user_id = $_SESSION["user_id"] ?? null;

        if (!$user_id) return false;

        return $this->connection->prepare($sql)->execute([$title, $content, $created_at, $photo_path, $file_path, $user_id]);
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

    public function update($id, $title, $content, $photo_path, $file_path)
    {
        $sql = "UPDATE posts SET title = ?, content = ?, photo_path = ?, file_path = ? WHERE id = ?";
        return $this->connection->prepare($sql)->execute([$title, $content, $photo_path, $file_path, $id]);
    }


    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
