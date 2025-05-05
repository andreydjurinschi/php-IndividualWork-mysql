<?php

namespace Controllers\User;
require_once __DIR__ . "/../../Services/UserService.php";
use Services\UserService;
class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function createUser(){
        try {
            return $this->userService->create($_POST);
        } catch (\CreateEntityException $e) {
            return $e->getMessage();
        }
    }

    public function getAllUsers(): array {
        return $this->userService->getAllUsers();
    }

    public function updateUser(){
        try {
            return $this->userService->update($_POST);
        } catch (\CreateEntityException $e) {
            return $e->getMessage();
        }
    }
}