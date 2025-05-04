<?php

namespace Controllers\User;

use Services\UserService;

require_once '../../Services/UserService.php';
class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function createUser(){
        return $this->userService->create($_POST);
    }


}