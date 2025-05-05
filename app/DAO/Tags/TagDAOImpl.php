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
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($row) {
                return $row['id'];
            }

            $sql = "INSERT INTO tags (name) VALUES (?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$tagName]);

            return $this->connection->lastInsertId();
        }
        public function getAllTags(): array
        {
            $tags = $this->connection->query("SELECT id, name FROM tags")->fetchAll(\PDO::FETCH_ASSOC);
            var_dump($tags);
            return $tags;
        }
}