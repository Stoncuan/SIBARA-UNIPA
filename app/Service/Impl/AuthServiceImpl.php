<?php

namespace App\Service\Impl;

use App\Service\AuthService;
use Auth;

class AuthServiceImpl implements AuthService
{
    public function login($username, $password):bool{
        return Auth::attempt([
            "username" => $username,
            "password" => $password
        ]);
    }
}
