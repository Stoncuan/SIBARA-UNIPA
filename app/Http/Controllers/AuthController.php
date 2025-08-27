<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function login(){
        return Response()->view("auth.login", [
            "title" => "SIBARA-UNIPA"
        ]);
    }

    public function doLogin(Request $request){
        $validasiLogin = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $validasiLogin['username'];
        $password = $validasiLogin['password'];

        if($this->authService->login($username, $password)){
            $request->session()->put("username", $username);
            return redirect("/");
        }

        return response()->view("auth.login", [
            "title" => "Login Peminjaman Barang UPA TIK UNIPA",
            "messageLogin" => "Username atau password salah"
        ]);
    }

    public function doLogout(Request $request){
        $request->session()->forget("username");

        return response()->view("auth.login", [
            "title" => "SIBARA-UNIPA",
            "message" => "Anda sudah logout"
        ]);
    }
}
