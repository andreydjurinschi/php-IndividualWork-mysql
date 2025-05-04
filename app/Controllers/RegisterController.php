<?php

namespace Controllers;
use database\databaseConnector;
class RegisterController
{
    public function register(){
        session_start();
        require_once __DIR__ . "/../../database/databaseConnector.php";
        $_SESSION['error'] = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'register'){
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';

        }
    }
}