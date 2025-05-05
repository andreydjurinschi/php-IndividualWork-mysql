<?php

namespace DAO\User;

interface UserDAO
{
    public function create($username, $password, $email);
    public function update($id, $role_id);
    public function delete($username);
    public function findById(int $id);
    public function getAll();
}