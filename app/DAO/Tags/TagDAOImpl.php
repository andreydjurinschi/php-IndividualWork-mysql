<?php

namespace DAO\Tags;
require_once __DIR__ . "/../../../database/databaseConnector.php";
require_once __DIR__ . "/TagDAO.php";
use database\databaseConnector;

class TagDAOImpl implements TagDAO
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
            throw new \dbConnectException($e.getMessage(), 500, $e);
        }
    }

        public function getTagId($tagName)
        {
            $sql = "SELECT id FROM tags WHERE name = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$tagName]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        public function getAllTags(): array
        {
            $tags = $this->connection->query("SELECT * FROM tags")->fetchAll(\PDO::FETCH_ASSOC);
            return $tags;
        }

        public function getTagForPost($post_id)
        {
            $sql = "SELECT t.name FROM tags t
                    JOIN post_tags pt ON t.id = pt.tag_id
                    WHERE pt.post_id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$post_id]);
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        }
}