<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ValidasiLoginController::class, 'validasiLogin']);


Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'login')->middleware('only_guest');
    Route::post('/login', 'doLogin')->middleware('only_guest');
    Route::post('/logout', 'doLogout');
});

Route::controller(\App\Http\Controllers\BarangController::class)
->middleware('only_member')->group(function () {
    Route::get('/peminjaman-barang', 'homeBarang');
});

