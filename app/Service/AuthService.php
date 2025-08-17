<?php

namespace App\Service;
use PhpParser\Builder\Interface_;

interface AuthService
{
    function login (string $username, string $password): bool;
    
}
