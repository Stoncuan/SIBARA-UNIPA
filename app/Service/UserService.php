<?php

namespace App\Service;
use App\Models\User;
use Auth;
use PhpParser\Builder\Interface_;

interface UserService
{
    public function getAllUser();

    public function createUser(string $name, string $username, string $password);
    
    public function updateUser(int $id, string $name, string $password);

    public function deleteUser(int $id);
}
