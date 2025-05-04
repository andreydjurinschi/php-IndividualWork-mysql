<?php

namespace DAO\User;

interface UserDAO
{
    public function create($username, $password, $email);
    public function update($username, $password, $email);
    public function delete($username);
}