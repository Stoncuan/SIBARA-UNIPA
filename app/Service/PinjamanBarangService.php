<?php

namespace App\Service;
use PhpParser\Builder\Interface_;

interface PinjamanBarangService
{
    public function pinjamBarang(
        string $nama_barang, 
        string $keperluan_barang,
        $total_pinjam,
        string $tanggal_pinjam_barang,
        string $nama_penanggung_jawab,
        string $status_barang,
        $id_barang
    );

    public function kembalikanBarang(
        int $id,
        string $status_barang
    );

    public function updatePinjamBarang(
        string $id,
        string $nama_barang,
        string $keperluan_barang,
        int $total_pinjam,
        string $tanggal_pinjam_barang,
        string $tanggal_barang_kembali,
        string $nama_penanggung_jawab,
        string $status_barang
    );

    public function deletePinjaman(int $id);

    public function getPinjamanByUser();

    public function getAllPinjaman();

    public function getTotalPinjaman();
}
