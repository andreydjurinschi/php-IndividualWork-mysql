<?php
namespace DAO\User;
require_once __DIR__ . "/../../../database/databaseConnector.php";
require_once __DIR__ . "/UserDAO.php";
use database\databaseConnector;
class UserDaoImpl implements UserDAO
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


    public function create($username, $password, $email)
    {
        $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, 2)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$username, hash('sha256', $password), $email, 2]);
    }

    public function update($username, $password, $email)
    {
        // TODO: Implement update() method.
    }

    public function delete($username)
    {
        // TODO: Implement delete() method.
    }
}