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
    Route::get('/gambar-barang/{path}',  'viewGambarBarang')
    ->where('path', '.*'); 
    
    Route::get('/peminjaman-barang', 'homeBarang');

    Route::post('/tambah-barang', 'createBarang');
    Route::post('/hapus-barang/{id}', 'deleteBarang');
    Route::post('/edit-barang', 'updateBarang');
});

Route::controller(\App\Http\Controllers\PinjamanBarangController::class)
->middleware('only_member')->group(function () {
    Route::post('/pinjam-barang', 'createPinjaman');
    Route::post('/kembalikan-barang/{id}', 'kembalikanBarang');
});

Route::controller(\App\Http\Controllers\UserController::class)
->middleware('only_member')->group(function () {
    Route::post('/tambah-user', 'createUser');
    Route::get('/edit-user/{id}', 'showUpateUser');
    Route::post('/edit-user', 'updateUser');
    Route::get('/edit-user-profile', 'showEditUserProfile');
    Route::post('/edit-user-profile', 'updateUserProfile');
    Route::post('/hapus-user/{id}', 'deleteUser');
    Route::post('/tambah-user', 'createUser');
});



