<?php

namespace App\Service\Impl;

use App\Models\Barang;
use App\Models\pinjaman_barang;
use App\Service\BarangService;
use Storage;

class BarangServiceImpl implements BarangService
{
    public function getAllBarang(){
        return Barang::query()->paginate(15);
    }
    public function createBarang(
        string $nama_barang, 
        string $penjelasan_barang, 
        string $gambar_barang, 
        int $total_barang, 
        int $barang_tersedia,
    ){
        $barang = new Barang([
            "nama_barang" => $nama_barang,
            "penjelasan_barang" => $penjelasan_barang,
            "gambar_barang" => $gambar_barang,
            "total_barang" => $total_barang,
            "barang_tersedia" => $barang_tersedia,
        ]);

        $barang->save();
    }

    public function updateBarang(
        int $id,
        string $nama_barang,
        string $penjelasan_barang,
        string $gambar_barang,
        int $total_barang,
        int $barang_tersedia
    ){
        $barang = Barang::query()->find($id);
        $barang->nama_barang = $nama_barang;
        $barang->penjelasan_barang = $penjelasan_barang;
        $barang->gambar_barang = $gambar_barang;
        $barang->total_barang = $total_barang;
        $barang->barang_tersedia = $barang_tersedia;
        $barang->save();
    }

    public function getBarangById(int $id){
        return Barang::query()->find($id);
    }

    public function deleteBarang(int $id){
        $barang = Barang::query()->find($id);
        if($barang['gambar_barang'] != null){
            Storage::disk('local')->delete($barang['gambar_barang']);
        }
        if($barang != null){
            $barang->delete();
        }
    }

    public function totalBarang(){
        return Barang::query()->sum('total_barang');
    }

    public function totalBarangTersedia(){
        $barangPinjam = pinjaman_barang::query()->sum('total_pinjam');
        $barang = Barang::query()->sum('total_barang');
        return $barang - $barangPinjam;
    }
}
