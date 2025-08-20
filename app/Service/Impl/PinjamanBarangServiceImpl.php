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
        $total_pinjam,
        string $tanggal_pinjam_barang,
        string $nama_penanggung_jawab,
        string $status_barang
    ){
        $pinjamBarang = new pinjaman_barang([
            "nama_barang" => $nama_barang,
            "keperluan_barang" => $keperluan_barang,
            "total_pinjam" => $total_pinjam,
            "tanggal_pinjam_barang" => $tanggal_pinjam_barang,
            "nama_penanggung_jawab" => $nama_penanggung_jawab,
            "status_barang" => $status_barang
        ]);

        $pinjamBarang->save();
    }

    public function updatePinjamBarang(
        string $id,
        string $nama_barang,
        string $keperluan_barang,
        int $total_pinjam,
        string $tanggal_pinjam_barang,
        string $tanggal_barang_kembali,
        string $nama_penanggung_jawab,
        string $status_barang
    ){
        $pinjamBarang = pinjaman_barang::query()->find($id);
        $pinjamBarang->nama_barang = $nama_barang;
        $pinjamBarang->keperluan_barang = $keperluan_barang;
        $pinjamBarang->total_pinjam = $total_pinjam;
        $pinjamBarang->tanggal_pinjaman_barang = $tanggal_pinjam_barang;
        $pinjamBarang->tanggal_barang_kembali = $tanggal_barang_kembali;
        $pinjamBarang->nama_penanggung_jawab = $nama_penanggung_jawab;
        $pinjamBarang->status_barang = $status_barang;

        $pinjamBarang->save();
        
    }

    public function deletePinjaman(int $id){
        $pinjamanBarang = pinjaman_barang::query()->find($id);

        if($pinjamanBarang != null){
            $pinjamanBarang->delete();
        }
    }

    public function getPinjamanByUser(){
        $user = Auth::user();

        return pinjaman_barang::query()->where('nama_penanggung_jawab', '=', $user['username'])->get();
    }

    public function getAllPinjaman(){
        return pinjaman_barang::query()->get();
    }

    public function getTotalPinjaman(){
        return pinjaman_barang::query()->sum('total_pinjam');
    }

}
