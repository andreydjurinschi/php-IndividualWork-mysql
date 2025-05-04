<?php

namespace Controllers;
use handlers\UserFormHandler;
require_once __DIR__ . "/../../src/handlers/UserFormHandler.php";
class RegisterController
{
    /**
     * Обрабатывает регистрацию нового пользователя.
     *
     * @return string|null Возвращает строку с сообщением об ошибке, если регистрация не удалась,
     * или перенаправляет пользователя на страницу входа в случае успеха.
     */
    public function register(){
        session_start();
        require_once __DIR__ . "/../../database/databaseConnector.php";
        $_SESSION['error'] = null;
        $handler = new UserFormHandler();
        $result = $handler->handleRegister();
        if(is_string($result)){
            $_SESSION['error'] = $result;
            return $result;
        }
        header('Location: /login');
        exit();
    }
}