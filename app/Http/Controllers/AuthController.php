<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(){
        return response()->view("auth.login", [
            "title" => "Login Peminjaman Barang UPA TIK UNIPA"
        ]);
    }

    public function doLogin(Request $request){
        $validasiLogin = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $validasiLogin['username'];
    }
}
