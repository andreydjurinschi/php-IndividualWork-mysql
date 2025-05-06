<?php

namespace Services;
require_once __DIR__ . "/../DAO/User/UserDaoImpl.php";
use DAO\User\UserDaoImpl;

class AuthService
{
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDaoImpl();
    }

    public function authenticate(string $username, string $password): ?array {
        $user = $this->userDao->findByUsername($username);
        if ($user && hash('sha256', $password) === $user['password']) {
            return $user;
        }
        return null;
    }
}