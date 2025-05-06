<?php

namespace Controllers;

require_once __DIR__.'/../../src/handlers/LoginHandler.php';
use handlers\LoginHandler;
class AuthenticationController
{

    /**
     * Выполняет вход пользователя в систему.
     *
     * Этот метод обрабатывает POST-запросы с действием "login".
     * Если учетные данные пользователя верны, создается сессия и пользователь перенаправляется на главную страницу.
     * В случае ошибки входа устанавливается сообщение об ошибке и выполняется перенаправление на страницу входа.
     */
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

    /**
     * Выполняет выход пользователя из системы.
     *
     * Этот метод завершает текущую сессию пользователя, очищает данные сессии
     * и перенаправляет пользователя на страницу входа.
     */
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /login");
        exit;
    }
}
