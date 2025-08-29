<?php

namespace App\Service;
use App\Models\User;
use Auth;
use PhpParser\Builder\Interface_;

interface UserService
{
    public function getAllUser();

    public function getUserById(int $id);

    public function createUser(string $name, string $username, string $password, $role);
    
    public function updateUser(int $id, string $name, string $password);

    public function updateUserNoPassword(int $id, string $name);

    public function deleteUser(int $id);

    public function getUserSession();

    public function getUserByUsername($username);
}
