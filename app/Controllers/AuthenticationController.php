<?php

namespace Controllers;

require_once __DIR__.'/../../src/handlers/LoginHandler.php';
use handlers\LoginHandler;
class AuthenticationController
{
    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
            $handler = new LoginHandler();
            $user = $handler->handleLogin($_POST);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: /");
                exit;
            }

            $_SESSION['error'] = 'Wrong username or password';
            header("Location: /login");
            exit;
        }

        require __DIR__ . '/../../app/Views/AccountViews/loginView.php';
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /login");
        exit;
    }
}
