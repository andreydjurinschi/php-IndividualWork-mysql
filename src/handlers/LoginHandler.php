<?php

namespace handlers;
require_once __DIR__ . "/../../app/Services/AuthService.php";
use Services\AuthService;

class LoginHandler
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function handleLogin(array $post): ?array
    {
        $username = $post['username'] ?? '';
        $password = $post['password'] ?? '';

        return $this->authService->authenticate($username, $password);
    }
}