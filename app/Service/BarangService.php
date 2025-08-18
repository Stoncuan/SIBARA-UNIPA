<?php

namespace App\Service;
use PhpParser\Builder\Interface_;

interface BarangService
{
    public function getAllBarang();

    public function createBarang(
        string $nama_barang, 
        string $penjelasan_barang, 
        string $gambar_barang, 
        int $total_barang, 
        int $barang_tersedia,
    );

    public function updateBarang(
        int $id,
        string $nama_barang,
        string $penjelasan_barang,
        string $gambar_barang,
        int $total_barang,
        int $barang_tersedia
    );

    public function getBarangById(int $id);

    public function deleteBarang(int $id);

    public function totalBarang();

    public function totalBarangTersedia();
}
