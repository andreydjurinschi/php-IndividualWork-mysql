<?php

namespace handlers;
require_once __DIR__ . "/../../app/Controllers/User/UserController.php";
use Controllers\User\UserController;

class UserFormHandler
{
    private $userController;
    public function __construct()
    {
        $this->userController = new UserController();
    }

    public function handleRegister(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
            $message = $this->userController->createUser();
            if (is_string($message)) {
                return $message;
            }
            return null;
        }
        return null;
    }

    public function handleUpdate(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
            $message = $this->userController->updateUser();
            $_GET= [];
            $_POST = [];
            if (is_string($message)) {
                return $message;
            }
            return null;
        }
        return null;
    }
}