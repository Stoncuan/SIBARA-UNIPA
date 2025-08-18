<?php

namespace App\Service\Impl;

use App\Models\Barang;
use App\Models\pinjaman_barang;
use App\Service\PinjamanBarangService;
use Auth;

class PinjamanBarangServiceImpl implements PinjamanBarangService
{
    public function pinjamBarang(
        string $nama_barang, 
        string $keperluan_barang,
        int $total_pinjam,
        string $tanggal_pinjam_barang,
        string $tanggal_barang_kembali,
        string $nama_penanggung_jawab,
        string $status_barang
    ){

    }

    public function getPinjamanByUser(){
        $user = Auth::user();

        return pinjaman_barang::query()->where('nama_penanggung_jawab', '=', $user['username'])->get();
    }

    public function getAllPinjaman(){
        return pinjaman_barang::query()->get();
    }

}
