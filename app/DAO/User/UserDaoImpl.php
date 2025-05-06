<?php
namespace DAO\User;
require_once __DIR__ . "/../../../database/databaseConnector.php";
require_once __DIR__ . "/UserDAO.php";
use database\databaseConnector;
use PDO;

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

    /**
     * Создает нового пользователя в базе данных.
     *
     * @param string $username Имя пользователя.
     * @param string $password Пароль пользователя (хэшируется перед сохранением).
     * @param string $email Электронная почта пользователя.
     * @return bool Возвращает true, если пользователь успешно создан, иначе false.
     */
    public function create($username, $password, $email)
    {
        $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, 2)";
        return $this->connection->prepare($sql)->execute([$username, hash('sha256', $password), $email]);
    }

    /**
     * Обновляет данные существующего пользователя в базе данных.
     *
     * @param int $role_id Новый идентификатор роли пользователя.
     * @return bool Возвращает true, если данные пользователя успешно обновлены, иначе false.
     */
    public function update($id,$role_id): bool
    {
        $sql = "UPDATE users SET role_id = ? WHERE id = $id";
        return $this->connection->prepare($sql)->execute([$role_id]);
    }

    /**
     * Удаляет пользователя из базы данных по его идентификатору.
     *
     * @param int $id Идентификатор пользователя, которого нужно удалить.
     * @return void
     */
    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE user_id = ?");
        $stmt->execute([$id]);
        $stmt = $this->connection->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function findById(int $id) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAll(): array {
        $sql = "SELECT * FROM users";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username): ?array {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

}