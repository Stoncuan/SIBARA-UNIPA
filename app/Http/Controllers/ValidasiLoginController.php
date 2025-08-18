<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidasiLoginController extends Controller
{
    public function validasiLogin(Request $request){
        if($request->session()->exists("username")){
            return redirect("/peminjaman-barang");
        }else {
            return redirect("/login");
        }
    }
}
