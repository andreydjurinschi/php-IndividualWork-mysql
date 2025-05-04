<?php

namespace Controllers;

use database\databaseConnector;

class AuthenticationController
{
    public function login() {
        session_start();
        require_once __DIR__ . "/../../database/databaseConnector.php";
        $_SESSION['error'] = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $database = new databaseConnector();
            try {
                $pdo = $database->createConnection();
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user && hash('sha256', $password) === $user['password']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role_id'] = $user['role_id'];
                    header('Location: /');
                    exit;
                }
                $_SESSION['error'] = 'Invalid credentials';
                header("Location: /login");
                exit();
            } catch (\dbConnectException $e) {
                $_SESSION['error'] = 'Database connection failed';
                header("Location: /login");
                exit();
            }
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
